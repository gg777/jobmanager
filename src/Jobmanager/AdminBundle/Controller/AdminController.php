<?php


namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Entity\Company;
use Jobmanager\AdminBundle\Entity\Contact;
use Jobmanager\AdminBundle\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jobmanager\AdminBundle\Entity\Jobs;

class AdminController extends Controller
{
    public function indexAction()
    {
        //$this->updateDbAction();

        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve last jobs
        $jobs = $em->getRepository('JobmanagerAdminBundle:Job')
                   ->getJobs();

//        print "<pre>"; \Doctrine\Common\Util\Debug::dump($jobs[0]->getCompany()); print "</pre>";
//        die('coucou');

        // send view
        return $this->render('JobmanagerAdminBundle:Admin:index.html.twig', array(
            'jobs' => $jobs
        ));
    }

    public function updateDbAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve jobs entries
        $jobs_import = $em->getRepository('JobmanagerAdminBundle:Jobs')
                          ->findAll();

        // for each jobs entry split data and insert them on job and company table
        foreach ($jobs_import as $job_import) {

            // create new job
            $job = new Job();
            $job->setName($job_import->getPosition());
            $job->setCreatedDate($job_import->getDate());
            $job->setUrlJob($job_import->getUrlJob());

            // set Contact and Company
            $em->getRepository('JobmanagerAdminBundle:Job')
               ->setCompanyToJob($em, $job_import, $job);
            $em->persist($job);
            $em->flush();

        }

        print "<pre>"; \Doctrine\Common\Util\Debug::dump($jobs_import); print "</pre>";
        die;

        // send view
        return $this->render('JobmanagerAdminBundle:Admin:index.html.twig');
    }

} 