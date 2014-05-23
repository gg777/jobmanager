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

        // call entity manager
        $em = $this->getContainer()->get('doctrine')->getManager();

        // call jobImport service
        $jobImportService = $this->getContainer()->get('jobmanager_admin.jobimport');

        $jobsImport = $jobImportService->importRemixjobs($em);

        // check if no job
        if ($jobsImport == null) {
            // send email new job
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
                    ->setSubject('Nouveau poste Symfony 2 - Remixjobs')
                    ->setFrom('pa@foulquier.info')
                    ->setTo('pa@foulquier.info')
                    ->setBody($this->getContainer()->get('templating')->render('JobmanagerAdminBundle:Admin:remixjobsEmail.txt.twig', array(
                        'postingJob' => $job->description
                    )));
                $this->getContainer()->get('mailer')->send($message);

                // send output cmd
                $output->writeln($job->title);
            }

        }

    }

} 