<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobExperience
 *
 * @ORM\Table(name="job_experience")
 * @ORM\Entity(repositoryClass="Jobmanager\AdminBundle\Entity\JobExperienceRepository")
 */
class JobExperience
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title_job", type="string", length=255, nullable=true)
     */
    private $titleJob;

    /**
     * @var string
     *
     * @ORM\Column(name="company_name", type="string", length=255, nullable=true)
     */
    private $companyName;

    /**
     * @var
     *
     * @ORM\Column(name="contract_type", type="string", length=255, nullable=true)
     */
    private $contractType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_begin", type="datetime", nullable=true)
     */
    private $dateBegin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_end", type="datetime", nullable=true)
     */
    private $dateEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Jobmanager\AdminBundle\Entity\Candidate")
     */
    private $candidate;


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
     * Set titleJob
     *
     * @param string $titleJob
     * @return JobExperience
     */
    public function setTitleJob($titleJob)
    {
        $this->titleJob = $titleJob;

        return $this;
    }

    /**
     * Get titleJob
     *
     * @return string 
     */
    public function getTitleJob()
    {
        return $this->titleJob;
    }

    /**
     * Set companyName
     *
     * @param string $companyName
     * @return JobExperience
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string 
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set dateBegin
     *
     * @param \DateTime $dateBegin
     * @return JobExperience
     */
    public function setDateBegin($dateBegin)
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    /**
     * Get dateBegin
     *
     * @return \DateTime 
     */
    public function getDateBegin()
    {
        return $this->dateBegin;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return JobExperience
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return JobExperience
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    

    /**
     * Set contractType
     *
     * @param string $contractType
     * @return JobExperience
     */
    public function setContractType($contractType)
    {
        $this->contractType = $contractType;

        return $this;
    }

    /**
     * Get contractType
     *
     * @return string 
     */
    public function getContractType()
    {
        return $this->contractType;
    }

    /**
     * Set candidate
     *
     * @param \Jobmanager\AdminBundle\Entity\Candidate $candidate
     * @return JobExperience
     */
    public function setCandidate(\Jobmanager\AdminBundle\Entity\Candidate $candidate = null)
    {
        $this->candidate = $candidate;

        return $this;
    }

    /**
     * Get candidate
     *
     * @return \Jobmanager\AdminBundle\Entity\Candidate 
     */
    public function getCandidate()
    {
        return $this->candidate;
    }
}
