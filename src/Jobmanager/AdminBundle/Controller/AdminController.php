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
//            $em->getRepository('JobmanagerAdminBundle:Job')
//               ->setCompanyToJob($em, $job_import, $job);
            $company = $this->setCompanyToJob($em, $job_import, $job);
            $em->persist($job);

            $em->flush();

        }



        print "<pre>"; \Doctrine\Common\Util\Debug::dump($jobs_import); print "</pre>";
        die;

        // send view
        return $this->render('JobmanagerAdminBundle:Admin:index.html.twig');
    }


    /**
     * import db v1
     * test if company has contact
     * and if no attach it
     * @param $em
     * @param $job_import
     * @param $company
     * @return Contact
     */
    private function setContactToCompany($em, $job_import,$company)
    {
        // ** for the new job created create a contact if not exist
        // ** attach the contact to the company

        // retrieve contact name from company entity
        $contact_import = $job_import->getContactFirstName();

        $contact = $em->getRepository('JobmanagerAdminBundle:Contact')
                      ->findByFirstName($contact_import);

        // check if contact exists
        if (empty($contact)) {
            // if not exist create a new one
            $contact = new Contact();
            $contact->setGender($job_import->getContactGenre());
            $contact->setFirstName($job_import->getContactFirstname());
            $contact->setLastName($job_import->getContactLastname());
            $contact->setTel($job_import->getTel());
            $contact->setEmail($job_import->getEmail());

            // attach to contact
            $contact->setCompany($company);

            return $contact;
        } else {
            // if exists attach to contact
            $contact[0]->setCompany($company);

            return $contact[0];
        }
    }

    /**
     * import db v1
     * test if company has contact
     * @param $em
     * @param $job_import
     * @param $job
     * @return Company
     */
    private function setCompanyToJob($em, $job_import, $job)
    {
        // ** for the new job created create a company if not exist
        // ** attach the company to the job

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

            // set contact to company
            $contact = $this->setContactToCompany($em, $job_import, $company);

            // attache to job
            $job->setCompany($company);

            // persist
            $em->persist($company);
            $em->persist($contact);

            return $company;

        } else {

            // if exists attach to job
            $job->setCompany($company[0]);

            return $company[0];

        }


    }

} 