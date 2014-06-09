<?php

namespace Jobmanager\AdminBundle\Service;

use \Jobmanager\AdminBundle\Entity\Job;
use \Jobmanager\AdminBundle\Entity\Company;
use \Jobmanager\AdminBundle\Entity\Recruiter;
use \Jobmanager\AdminBundle\Entity\Recall;

class FormToEntity
{
    /**
     * Create and hydrate company object
     * @param $dataForm
     * @return Company
     */
    public function createCompany($dataForm)
    {
        //print '<pre>'; print_r($dataForm); print '</pre>';

        // create new company
        $company = new Company();
        $company->setName($dataForm['jobmanager_adminbundle_company[name']);

        $company->setType($dataForm['jobmanager_adminbundle_company[type']);
        $company->setSector($dataForm['jobmanager_adminbundle_company[sector']);
        $company->setAddress($dataForm['jobmanager_adminbundle_company[address']);
        $company->setZip($dataForm['jobmanager_adminbundle_company[zip']);
        $company->setCity($dataForm['jobmanager_adminbundle_company[city']);
        $company->setCountry($dataForm['jobmanager_adminbundle_company[country']);
        $company->setLat($dataForm['jobmanager_adminbundle_company[lat']);
        $company->setLng($dataForm['jobmanager_adminbundle_company[lng']);

        if (isset($dataForm['jobmanager_adminbundle_company[is_head_hunter']))
            $company->setIsHeadHunter($dataForm['jobmanager_adminbundle_company[is_head_hunter']);
        else
            $company->setIsHeadHunter(0);

        return $company;
    }

    /**
     * Create and hydrate job object
     * @param $dataForm
     * @param Company $company
     * @return Job
     */
    public function createJob($dataForm, Company $company)
    {
        // create new job
        $job = new Job();
        $job->setCreatedDate(new \DateTime());
        $job->setCompany($company);
        $job->setName($dataForm['jobmanager_adminbundle_superjob[name']);
        $job->setUrlJob($dataForm['jobmanager_adminbundle_superjob[urlJob']);
        $job->setRemixjobsId($dataForm['jobmanager_adminbundle_superjob[remixjobs_id']);
        $job->setContractType($dataForm['jobmanager_adminbundle_superjob[contract_type']);
        $job->setPostingJob($dataForm['jobmanager_adminbundle_superjob[posting_job']);
        $job->setIsApplied(0);
        $job->setIsSoldout(0);

        return $job;
    }

    /**
     * Create and hydrate recruiter object
     * @param $dataForm
     * @param $company
     * @return Recruiter
     */
    public function createRecruiter($dataForm, $company)
    {
        // create new recruiter
        $recruiter = new Recruiter();

        // bind data
        $recruiter->setGender($dataForm['jobmanager_adminbundle_recruiter[gender']);
        $recruiter->setFirstName($dataForm['jobmanager_adminbundle_recruiter[firstName']);
        $recruiter->setLastName($dataForm['jobmanager_adminbundle_recruiter[lastName']);
        $recruiter->setTel($dataForm['jobmanager_adminbundle_recruiter[tel']);
        $recruiter->setMobile($dataForm['jobmanager_adminbundle_recruiter[mobile']);
        $recruiter->setEmail($dataForm['jobmanager_adminbundle_recruiter[email']);

        if (is_array($company))
            $recruiter->setCompany($company[0]);
        else
            $recruiter->setCompany($company);

        return $recruiter;
    }

    /**
     * Create and hydrate recall object
     * @param $em
     * @param $dataForm
     * @param Recruiter $recruiter
     * @return Recall
     */
    public function createRecall($em, $dataForm, Recruiter $recruiter)
    {
        // create new recall
        $recall = new Recall();

        // bind data
        $createdDate = new \DateTime();
        $createdDate->setDate($dataForm['jobmanager_adminbundle_superrecall[createdDate']['date']['year'], $dataForm['jobmanager_adminbundle_superrecall[createdDate']['date']['month'], $dataForm['jobmanager_adminbundle_superrecall[createdDate']['date']['day']);
        $createdDate->setTime($dataForm['jobmanager_adminbundle_superrecall[createdDate']['time']['hour'], $dataForm['jobmanager_adminbundle_superrecall[createdDate']['time']['minute'], 0);
        $recall->setCreatedDate($createdDate);

        $recallDate = new \DateTime();
        $recallDate->setDate($dataForm['jobmanager_adminbundle_superrecall[recallDate']['date']['year'], $dataForm['jobmanager_adminbundle_superrecall[recallDate']['date']['month'], $dataForm['jobmanager_adminbundle_superrecall[recallDate']['date']['day']);
        $recall->setRecallDate($recallDate);

        if (isset($dataForm['jobmanager_adminbundle_superrecall[isFirstContact']))
            $recall->setIsFirstContact($dataForm['jobmanager_adminbundle_superrecall[isFirstContact']);
        else
            $recall->setIsFirstContact(0);

        if (isset($dataForm['jobmanager_adminbundle_superrecall[isRecalled']))
            $recall->setIsRecalled($dataForm['jobmanager_adminbundle_superrecall[isRecalled']);
        else
            $recall->setIsRecalled(0);

        if (isset($dataForm['jobmanager_adminbundle_superrecall[isMail']))
            $recall->setIsMail($dataForm['jobmanager_adminbundle_superrecall[isMail']);
        else
            $recall->setIsMail(0);

        $jobSourceId = $dataForm['jobmanager_adminbundle_superrecall[jobSource'];
        $jobSource = $em->getRepository('JobmanagerAdminBundle:JobSource')
            ->findById($jobSourceId);
        $recall->setJobSource($jobSource[0]);

        $recall->setDescription($dataForm['jobmanager_adminbundle_superrecall[description']);
        $recall->setRecruiter($recruiter);

        return $recall;
    }
} 