<?php

namespace Jobmanager\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CheckRemixjobsCommand extends ContainerAwareCommand
{
    protected function configure()
    {

        $this->setName('remixjobs:check')
             ->setDescription('check new jobs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // call entity manager
        $em = $this->getContainer()->get('doctrine')->getManager();

        // call jobImport service
        $jobImportService = $this->getContainer()->get('jobmanager_admin.jobimport');

        // import jobs
        $jobsImport = $jobImportService->importRemixjobs($em, true);

        // check if no job
        if ($jobsImport == null) {

            // send email no new job
            $message = \Swift_Message::newInstance()
                ->setSubject('No new job')
                ->setFrom('pa@foulquier.info')
                ->setTo('pa@foulquier.info')
                ->setBody($this->getContainer()->get('templating')->render('JobmanagerAdminBundle:Admin:remixjobsEmail.txt.twig', array(
                    'postingJob' => null
                )));
            $this->getContainer()->get('mailer')->send($message);

            // send output cmd
            $output->writeln('no new jobs');

        } else {

            foreach ($jobsImport as $job) {

                // send email new job
                $message = \Swift_Message::newInstance()
                    ->setSubject('Nouveau poste - Remixjobs - '.$job->getName())
                    ->setFrom('pa@foulquier.info')
                    ->setTo('pa@foulquier.info')
                    ->setBody($this->getContainer()->get('templating')->render('JobmanagerAdminBundle:Admin:remixjobsEmail.txt.twig', array(
                        'postingJob' => $job->getPostingJob()
                    )));
                $this->getContainer()->get('mailer')->send($message);

                // send sms new job
                file_get_contents('https://smsapi.free-mobile.fr/sendmsg?user=11014182&pass=Jrc1R3XoyQDPJV&msg='.urlencode('Nouveau poste : '.str_replace('&', 'et', $job->getName()).' - '.$job->getUrlJob()));

                // send output cmd
                $output->writeln($job->getName());

            }

        }

    }

} 