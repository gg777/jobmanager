<?php


namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Entity\Company;
use Jobmanager\AdminBundle\Entity\Contact;
use Jobmanager\AdminBundle\Entity\Job;
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

//        print "<pre>"; \Doctrine\Common\Util\Debug::dump($jobs[0]->getCompany()); print "</pre>";
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