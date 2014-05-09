<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * JobRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class JobRepository extends EntityRepository
{

    public function getJobs()
    {
        $qb = $this->createQueryBuilder('j');

        $qb
            ->join('j.company', 'c')
            ->addSelect('c')
            ->join('c.recruiters', 'r')
            ->addSelect('r')
            ->orderBy('j.createdDate', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }
    /**
     * import db v1
     * test if company has contact
     * and if no attach it
     * @param $em
     * @param $job_import
     * @param $company
     * @return Recruiter
     */
    public function setRecruiterToCompany($em, $job_import,$company)
    {
        // ** for the new job created create a contact if not exist
        // ** attach the contact to the company

        // retrieve contact name from company entity
        $contact_import = $job_import->getContactFirstName();

        $contact = $em->getRepository('JobmanagerAdminBundle:Recruiter')
                      ->findByFirstName($contact_import);

        // check if contact exists
        if (empty($contact)) {
            // if not exist create a new one
            $contact = new Recruiter();
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
    public function setCompanyToJob($em, $job_import, $job)
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
            $contact = $this->setRecruiterToCompany($em, $job_import, $company);

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
