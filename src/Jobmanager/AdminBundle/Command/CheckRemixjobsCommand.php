<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 19/05/2014
 * Time: 23:05
 */

namespace Jobmanager\AdminBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Jobmanager\AdminBundle\Entity\Recruiter;
use Jobmanager\AdminBundle\Entity\Company;
use Jobmanager\AdminBundle\Entity\Job;


class CheckRemixjobsCommand extends ContainerAwareCommand
{
    protected function configure()
    {

        $this->setName('remixjobs:check')
             ->setDescription('check new jobs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // retrieve jobs from api
        $json_datas = file_get_contents('https://remixjobs.com/api/jobs');
        $jobsImport = json_decode($json_datas);

        // call entity manager
        $em = $this->getContainer()->get('doctrine')->getManager();

        // set output array
        $outputArr = array();

        // set filter sf2 jobs
        $sf2_occurences = array(
            'Symfony',
            'symfony',
            'Symfony 2',
            'Symfony2',
            'symfony 2',
            'symfony2',
            'sf2',
            'SF2'
        );

        // init job counter
        $jobCount = 0;

        // for each job ...
        foreach ($jobsImport->jobs as $jobImport) {

            // check if job already imported
            if ($em->getRepository('JobmanagerAdminBundle:Job')->getJobByRemixjobsId($jobImport->id) == null) {

                // check if title contain sf2 occurences
                foreach ($sf2_occurences as $sf2_occurence) {

                    // filter sf2 jobs
                    if (strpos($jobImport->title, $sf2_occurence) > 0) {
                        $flagSfJob = true;
                    }

                }

                if (isset($flagSfJob)) {

                    if ($flagSfJob === true) {

                        $jobCount++;

                        // unset flag
                        $flagSfJob = false;

                        // Recruiter
                        // parse postingJob to find recruiter contact
                        $description = $jobImport->description;

                        // instanciate new DOMDocument to parse HTML by tags as node
                        $dom = new \DOMDocument();
                        $dom->loadHTML($description);
                        foreach ($dom->getElementsByTagName('p') as $node) {

                            $arrayTag[] = $dom->saveHTML($node);

                        }

                        // check if has contact
                        foreach ($arrayTag as $tag) {

                            if (strpos($tag, 'Contact') == true) {

                                // parse contact
                                $contactArr = explode(' ', $tag);

                                $recruiter = new Recruiter();
                                $recruiter->setFirstName($contactArr[2]);
                                $recruiter->setLastName($contactArr[3]);

                                // check email string and clean
                                $email = str_replace('(', '', $contactArr[4]);
                                $email = str_replace(')', '', $email);
                                $recruiter->setEmail($email);

                                // reconstruct tel
                                $tel = $contactArr[6].' '.$contactArr[7].' '.$contactArr[8].' '.$contactArr[9].' '.$contactArr[10];

                                // check if is mobile tel
                                if ($contactArr[6] == 06) {
                                    $recruiter->setMobile($tel);
                                } else {
                                    $recruiter->setTel($tel);
                                }

                                //var_dump($recruiter); die;
                                $flagRecruiter = true;

                            } else {
                                $flagRecruiter = false;
                            }

                        }

                        // Company
                        $company = new Company();
                        $company->setName($jobImport->company_name);

                        if (isset($jobImport->company_website))
                            $company->setUrlCompany($jobImport->company_website);

                        // parse address
                        $addressArr = explode(',', $jobImport->geolocation->formatted_address);

                        $cityArr = explode(' ', $addressArr[1]);

                        $company->setAddress($addressArr[0]);
                        $company->setZip($cityArr[1]);
                        //$company->setCity($cityArr[2]);
                        //$company->setCountry($addressArr[2]);
                        $company->setLat($jobImport->geolocation->lat);
                        $company->setLng($jobImport->geolocation->lng);

                        if ($flagRecruiter == true) {
                            $company->setRecruiter($recruiter);
                        }


                        // Job
                        $job = new Job();
                        $job->setCreatedDate($jobImport->validation_time);
                        $job->setRemixjobsId($jobImport->id);
                        $job->setName($jobImport->title);
                        $job->setContractType($jobImport->contract_type);
                        $job->statusRemixjobs = $jobImport->status;
                        $job->setUrlJob($jobImport->_links->www->href);
                        $job->setCompany($company);
                        $job->setPostingJob($jobImport->description);

                        $outputArr[] = $job;

                        // send email
                        $message = \Swift_Message::newInstance()
                            ->setSubject('Nouveau poste Symfony 2 - Remixjobs')
                            ->setFrom('pa@foulquier.info')
                            ->setTo('pa@foulquier.info')
                            ->setBody($this->getContainer()->get('templating')->render('JobmanagerAdminBundle:Admin:remixjobsEmail.txt.twig', array(
                                'postingJob' => $jobImport->description
                            )));
                        $this->getContainer()->get('mailer')->send($message);

                        // send output cmd
                        $output->writeln($jobImport->title);

                    }

                }

            }

        }

        // check if no job
        if ($jobCount <= 0) {
            // send email
            $message = \Swift_Message::newInstance()
                ->setSubject('No new job')
                ->setFrom('pa@foulquier.info')
                ->setTo('pa@foulquier.info')
                ->setBody($this->getContainer()->get('templating')->render('JobmanagerAdminBundle:Admin:remixjobsEmail.txt.twig', array(
                    'postingJob' => null
                )));
            $this->getContainer()->get('mailer')->send($message);

            // send output cmd
            $output->writeln($jobImport->title);
        }

    }

} 