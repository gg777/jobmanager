<?php


namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Entity\Company;
use Jobmanager\AdminBundle\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jobmanager\AdminBundle\Entity\Jobs;

class AdminController extends Controller
{
    public function indexAction()
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


            // for the new job created create a company if not exist
            // attach the company to the job

            // retrieve company name from company entity
            $company_import = $job_import->getCompany();
            $company = $em->getRepository('JobmanagerAdminBundle:Company')
                          ->findByName($company_import);

            // check if company exists
            if (empty($company)) {

                // if not exists create a new one
                $company = new Company();
                $company->setName($job_import->getCompany());
                $company->setZip($job_import->getZip());
                $company->setCity($job_import->getCity());
                $company->setCountry('France');
                $company->setUrlCompany($job_import->getUrlCompany());

                // attache to job
                $job->setCompany($company);

                $em->persist($company);
                $em->persist($job);
                $em->flush();

            } else {

                // if exists attach to job
                $job->setCompany($company[0]);
                $em->persist($job);
                $em->flush();

            }

        }



        print "<pre>"; \Doctrine\Common\Util\Debug::dump($jobs_import); print "</pre>";
        die;

        // send view
        return $this->render('JobmanagerAdminBundle:Admin:index.html.twig');
    }

} 