<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Job
 *
 * @ORM\Table(name="job")
 * @ORM\Entity(repositoryClass="Jobmanager\AdminBundle\Entity\JobRepository")
 */
class Job
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url_job", type="string", length=255, nullable=true)
     */
    private $urlJob;

    /**
     * @var int
     *
     * @ORM\Column(name="remixjobs_id", type="bigint", nullable=true)
     */
    private $remixjobs_id;

    /**
     * @var string
     *
     * @ORM\Column(name="contract_type", type="string", length=255, nullable=true)
     */
    private $contract_type;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_soldout", type="boolean", nullable=true)
     */
    private $is_soldout;

    /**
     * @var bool
     * 
     * @ORM\Column(name="is_no_interest", type="boolean", nullable=true)
     */
    private $isNoInterest;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Jobmanager\AdminBundle\Entity\Company", cascade="persist")
     * @ORM\JoinColumn(nullable=true)
     */
    private $company;

    /**
     * @var
     * 
     * @ORM\ManyToOne(targetEntity="Jobmanager\AdminBundle\Entity\JobSource", cascade="persist")
     * @ORM\JoinColumn(nullable=true)
     */
    private $jobSource;

    /**
     * @var
     *
     * @ORM\Column(name="posting_job", type="text", nullable=true)
     */
    private $postingJob;

    /**
     * @var
     *
     * @ORM\Column(name="is_applied", type="boolean", nullable=true)
     */
    private $isApplied;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdDate = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Job
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Job
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set urlJob
     *
     * @param string $urlJob
     * @return Job
     */
    public function setUrlJob($urlJob)
    {
        $this->urlJob = $urlJob;

        return $this;
    }

    /**
     * Get urlJob
     *
     * @return string 
     */
    public function getUrlJob()
    {
        return $this->urlJob;
    }

    /**
     * Set remixjobs_id
     *
     * @param integer $remixjobsId
     * @return Job
     */
    public function setRemixjobsId($remixjobsId)
    {
        $this->remixjobs_id = $remixjobsId;

        return $this;
    }

    /**
     * Get remixjobs_id
     *
     * @return integer 
     */
    public function getRemixjobsId()
    {
        return $this->remixjobs_id;
    }

    /**
     * Set contract_type
     *
     * @param string $contractType
     * @return Job
     */
    public function setContractType($contractType)
    {
        $this->contract_type = $contractType;

        return $this;
    }

    /**
     * Get contract_type
     *
     * @return string 
     */
    public function getContractType()
    {
        return $this->contract_type;
    }

    /**
     * Set is_soldout
     *
     * @param boolean $isSoldout
     * @return Job
     */
    public function setIsSoldout($isSoldout)
    {
        $this->is_soldout = $isSoldout;

        return $this;
    }

    /**
     * Get is_soldout
     *
     * @return boolean 
     */
    public function getIsSoldout()
    {
        return $this->is_soldout;
    }

    /**
     * Set company
     *
     * @param \Jobmanager\AdminBundle\Entity\Company $company
     * @return Job
     */
    public function setCompany(\Jobmanager\AdminBundle\Entity\Company $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \Jobmanager\AdminBundle\Entity\Company 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set jobSource
     *
     * @param \Jobmanager\AdminBundle\Entity\JobSource $jobSource
     * @return Job
     */
    public function setJobSource(\Jobmanager\AdminBundle\Entity\JobSource $jobSource = null)
    {
        $this->jobSource = $jobSource;

        return $this;
    }

    /**
     * Get jobSource
     *
     * @return \Jobmanager\AdminBundle\Entity\JobSource 
     */
    public function getJobSource()
    {
        return $this->jobSource;
    }

    /**
     * Set postingJob
     *
     * @param string $postingJob
     * @return Job
     */
    public function setPostingJob($postingJob)
    {
        $this->postingJob = $postingJob;

        return $this;
    }

    /**
     * Get postingJob
     *
     * @return string 
     */
    public function getPostingJob()
    {
        return $this->postingJob;
    }

    /**
     * Set isApplied
     *
     * @param boolean $isApplied
     * @return Job
     */
    public function setIsApplied($isApplied)
    {
        $this->isApplied = $isApplied;

        return $this;
    }

    /**
     * Get isApplied
     *
     * @return boolean 
     */
    public function getIsApplied()
    {
        return $this->isApplied;
    }

    /**
     * Set isNoInterest
     *
     * @param boolean $isNoInterest
     * @return Job
     */
    public function setIsNoInterest($isNoInterest)
    {
        $this->isNoInterest = $isNoInterest;

        return $this;
    }

    /**
     * Get isNoInterest
     *
     * @return boolean 
     */
    public function getIsNoInterest()
    {
        return $this->isNoInterest;
    }
}
