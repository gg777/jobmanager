<?php


namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Entity\CandidateJob;
use Jobmanager\AdminBundle\Entity\Company;
use Jobmanager\AdminBundle\Entity\Contact;
use Jobmanager\AdminBundle\Entity\Fonecall;
use Jobmanager\AdminBundle\Entity\Job;
use Jobmanager\AdminBundle\Entity\Meeting;
use Jobmanager\AdminBundle\Entity\Recruiter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jobmanager\AdminBundle\Entity\Jobs;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve last jobs
        $jobs = $em->getRepository('JobmanagerAdminBundle:Job')
                   ->getJobs();

//        print "<pre>"; \Doctrine\Common\Util\Debug::dump($jobs[0]); print "</pre>";
//        die('coucou');

        // send view
        return $this->render('JobmanagerAdminBundle:Admin:index.html.twig', array(
            'jobs' => $jobs
        ));
    }

    public function getRemixjobsNewJobsAction()
    {
        $json_datas = file_get_contents('https://remixjobs.com/api/jobs');
        $jobs = json_decode($json_datas);
        foreach ($jobs->jobs as $job) {
            // filter sf2 jobs
            $sf2_occurences = array(
                'Symfony 2',
                'Symfony2',
                'symfony 2',
                'symfony2',
                'sf2',
                'SF2'
            );
            foreach ($sf2_occurences as $sf2_occurence) {
                if (strpos($job->title, $sf2_occurence) !== false) {
                    print '<pre>id :'; print_r($job->id); print '</pre>';
                    print '<pre>title :'; print_r($job->title); print '</pre>';
                    print '<pre>contract_type :'; print_r($job->contract_type); print '</pre>';
                    print '<pre>company_name :'; print_r($job->company_name); print '</pre>';
                    print '<pre>company_website :'; print_r($job->company_website); print '</pre>';
                    print '<pre>status :'; print_r($job->status); print '</pre>';
                    print '<pre>soldout :'; print_r($job->soldout); print '</pre>';
                    print '<pre>short_formatted_address :'; print_r($job->geolocation->short_formatted_address); print '</pre>';
                    print '<pre>formatted_address :'; print_r($job->geolocation->formatted_address); print '</pre>';
                    print '<pre>lat :'; print_r($job->geolocation->lat); print '</pre>';
                    print '<pre>lng :'; print_r($job->geolocation->lng); print '</pre>';
                    print '<pre>href :'; print_r($job->_links->www->href); print '</pre>';
                }
            }




        }
        //print '<pre>'; print_r($jobs->jobs[0]); print '</pre>';

        return new Response('OUESH');

    }

    public function updateDbAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve jobs entries
        $jobs_import = $em->getRepository('JobmanagerAdminBundle:Jobs')
                          ->findAll();

        // retrieve current candidate
        $candidate = $em->getRepository('JobmanagerAdminBundle:Candidate')
                        ->find(1);

//        print "<pre>"; \Doctrine\Common\Util\Debug::dump($candidate); print "</pre>";
//        die('coucou');

        // for each jobs entry split data and insert them on job and company table
        foreach ($jobs_import as $job_import) {

            // create new job
            $job = new Job();
            $job->setName($job_import->getPosition());
            $job->setCreatedDate($job_import->getDate());
            $job->setUrlJob($job_import->getUrlJob());


            // retrieve company by name
            $company = $em->getRepository('JobmanagerAdminBundle:Company')
                          ->findByName($job_import->getCompany());

            // check if company already exists
            if (empty($company)) {
                // company not exist
                // create company
                $company = new Company();
                $company->setName($job_import->getCompany());
                $company->setZip($job_import->getZip());
                $company->setCity($job_import->getCity());
                $company->setCountry('France');
                $company->setUrlCompany($job_import->getUrlCompany());

                // retrieve recruiter by name
                $recruiter = $em->getRepository('JobmanagerAdminBundle:Recruiter')
                                ->findByFirstName($job_import->getContactLastName());

                // check if company have empty recruiter
                if ($job_import->getContactFirstName() != null) {

                    // company has a recruiter
                    // check if company already have recruiter
                    if (empty($recruiter)) {

                        // no recruiter

                        echo 'no recruiter</br>';
                        // create recruiter
                        $recruiter = new Recruiter();
                        $recruiter->setGender($job_import->getContactGenre());
                        $recruiter->setFirstName($job_import->getContactFirstName());
                        $recruiter->setLastName($job_import->getContactLastName());
                        $recruiter->setTel($job_import->getTel());
                        $recruiter->setEmail($job_import->getEmail());
                        $em->persist($recruiter);

                        // attach recruiter company
                        $company->setRecruiter($recruiter);

                    }

                }

                // attach company to job
                $job->setCompany($company);

            }

            // check if job ist return as object or array
            if ($company instanceof Company) {
                $job->setCompany($company);
            } else {
                $job->setCompany($company[0]);
            }

            // persist job
            $em->persist($job);

            // flush
            $em->flush();

            // create new candidate_job
            $candidateJob = new CandidateJob();
            $candidateJob->setJob($job);
            $candidateJob->setCandidate($candidate);
            $candidateJob->setCreatedDate($job_import->getDate());
            $candidateJob->setInterest($job_import->getInterest());
            $candidateJob->setIsApplied(true);
            $candidateJob->setIsRejected($job_import->getOut());
            $candidateJob->setName($job_import->getPosition().' - '.$job_import->getCompany());

            // persist candidate_job
            $em->persist($candidateJob);



            // check if date meeting exist in import
            if ($job_import->getDateMeeting1() != null) {
                // if yes attach to meeting a candidate_job with answer
                // create a new meeting
                $meeting = new Meeting();
                $meeting->setCandidateJob($candidateJob);
                $meeting->setDateBegin($job_import->getDateMeeting1());
                $meeting->setDescription($job_import->getAnswer());
//                print "<pre>"; \Doctrine\Common\Util\Debug::dump($job_import->getDateMeeting1()->format('Y-m-d H:i:s')); print "</pre>";
//                die('coucou');
                $meeting->setName($job_import->getDateMeeting1()->format('Y-m-d H:i:s').' - '.$job_import->getCompany());

                // persist
                $em->persist($meeting);
            }

            // check if date answer exist in import

            if ($job_import->getDateAnswer() != null) {
                // if yes attach to fonecall a candidate_job with answer and contact inbound
                // create a new fonecall
                $fonecall = new Fonecall();
                $fonecall->setCandidateJob($candidateJob);
                $fonecall->setDateBegin($job_import->getDateAnswer());
                $fonecall->setDescription($job_import->getAnswer());
                $fonecall->setIsInbound($job_import->getContactInbound());
                $fonecall->setSource($job_import->getSource());

                // persist
                $em->persist($fonecall);
            }

            // flush
            $em->flush();

        }

        // todo finir la vue
        die('coucou');


        // send view
        return $this->render('JobmanagerAdminBundle:Admin:index.html.twig');
    }

} 