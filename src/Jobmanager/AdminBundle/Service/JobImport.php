<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 23/05/2014
 * Time: 09:54
 */

namespace Jobmanager\AdminBundle\Service;

use Jobmanager\AdminBundle\Entity\Job;
use Jobmanager\AdminBundle\Entity\Company;
use Jobmanager\AdminBundle\Entity\Recruiter;

/**
 * Class JobImport
 * @package Jobmanager\AdminBundle\Service
 */
class JobImport
{
    /**
     * Import jobs filtered by Symfony 2 from Remixjobs Api
     * @param $em
     * @return array
     */
    public function importRemixjobs($em)
    {
        // retrieve jobs from api
        $jobsImport = $this->getRemixjobsApi();

        // set output array
        $outputArr = array();

        // init job counter
        $jobCount = 0;

        // for each job ...
        foreach ($jobsImport->jobs as $jobImport) {

            // check if job already imported
            if ($em->getRepository('JobmanagerAdminBundle:Job')->getJobByRemixjobsId($jobImport->id) == null) {

                // check if title contain sf2 occurences
                $flagSfJob = $this->filterRemixjobs($jobImport);

                if (isset($flagSfJob)) {

                    if ($flagSfJob === true) {

                        $jobCount++;

                        // unset flag
                        $flagSfJob = false;

                        // Check if company already exists
                        $companies = $em->getRepository('JobmanagerAdminBundle:Company')
                                        ->findAll();

                        foreach ($companies as $company_test) {
                            if (strtolower(trim($company_test->getName())) == strtolower(trim($jobImport->company_name)))
                            {
                                $flagCompany = true;
                            }
                        }

                        if (isset($flagCompany) && $flagCompany == false) {
                            // Company
                            $company = $this->setNewCompany($jobImport);

                            // Recruiter
                            // parse postingJob to find recruiter contact
                            $recruiter = $this->setNewRecruiter($jobImport, $company);
                        } else {
                            $companyId = $company_test->getId();
                            $company = $em->getRepository('JobmanagerAdminBundle:Company')
                                          ->findById($companyId);
                            $company = $company[0];
                        }

                        // Job
                        $job = $this->setNewJob($jobImport, $company);

                        $outputArr[] = $job;

                        // persist job
                        $em->persist($job);
                        $em->flush();

                    }

                }

            }

        }

        //print "<pre>"; \Doctrine\Common\Util\Debug::dump($outputArr); print "</pre>"; die;

        // return
        return $outputArr;

    }

    /**
     * Retrieve jobs from remixjobs Api
     * @return mixed
     */
    private function getRemixjobsApi()
    {
        // retrieve jobs from api
        $json_datas = file_get_contents('https://remixjobs.com/api/jobs');
        $jobsImport = json_decode($json_datas);

        return $jobsImport;
    }

    /**
     * Filter job by Symfony 2 dictionary
     * @param $jobImport
     * @return bool
     */
    private function filterRemixjobs($jobImport)
    {
        // set filter sf2 jobs
        $sf2_occurences = array(
            'Symfony',
            'symfony',
            'Symfony 2',
            'Symfony2',
            'symfony 2',
            'symfony2',
            'sf2',
            'SF2',
            'PHP/Symfony2',
            'PHP-Symfony2'
        );

        // check if title contain sf2 occurences
        foreach ($sf2_occurences as $sf2_occurence) {

            // filter sf2 jobs
            if (strpos($jobImport->title, $sf2_occurence) > 0) {
                $flagSfJob = true;
            }

        }

        // check if lfag exists
        if (isset($flagSfJob)) {
            return $flagSfJob;
        } else {
            return false;
        }
    }

    /**
     * Set new job
     * @param $jobImport
     * @param Company $company
     * @return Job
     */
    private function setNewJob($jobImport, Company $company)
    {
        $job = new Job();
        $job->setCreatedDate(new \DateTime());
        $job->setRemixjobsId($jobImport->id);
        $job->setName($jobImport->title);
        $job->setContractType($jobImport->contract_type);
        $job->statusRemixjobs = $jobImport->status;
        $job->setUrlJob($jobImport->_links->www->href);
        $job->setCompany($company);
        $job->setPostingJob($jobImport->description);
        $job->setIsApplied(0);

        return $job;
    }

    /**
     * Set new company
     * @param $jobImport
     * @return Company
     */
    private function setNewCompany($jobImport)
    {
        $company = new Company();
        $company->setName($jobImport->company_name);

        if (isset($jobImport->company_website))
            $company->setUrlCompany($jobImport->company_website);

        // parse address
        $addressArr = explode(',', $jobImport->geolocation->formatted_address);

        $cityArr = explode(' ', $addressArr[1]);

        $company->setAddress($addressArr[0]);
        $company->setZip($cityArr[1]);
        $company->setLat($jobImport->geolocation->lat);
        $company->setLng($jobImport->geolocation->lng);

        return $company;
    }

    /**
     * Set new recruiter
     * @param $jobImport
     * @param Company $company
     * @return Recruiter|null
     */
    private function setNewRecruiter($jobImport, Company $company)
    {
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
                $recruiter->setCompany($company);
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

                return $recruiter;

            } else {
                return null;
            }

        }

    }

} 