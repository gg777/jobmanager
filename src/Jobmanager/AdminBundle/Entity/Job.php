<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Job
 *
 * @ORM\Table(name="job")
 * @ORM\Entity(repositoryClass="JobManager\AdminBundle\Entity\JobRepository")
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
     * @var
     *
     * @ORM\ManyToOne(targetEntity="\Jobmanager\AdminBundle\Entity\Company", inversedBy="jobs", cascade={"remove"})
     */
    private $company;

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
     * Set company
     *
     * @param \Jobmanager\AdminBundle\Entity\Company $company
     * @return Job
     */
    public function setCompany(\Jobmanager\AdminBundle\Entity\Company $company = null)
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
}
