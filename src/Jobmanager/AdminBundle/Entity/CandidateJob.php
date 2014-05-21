<?php
// src/Jobmanager/AdminBundle/Entity/CandidateJob.php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CandidateJob
 * @package Jobmanager\AdminBundle\Entity
 * @ORM\Entity
 * @ORM\Table("candidate_job")
 * @ORM\Entity(repositoryClass="Jobmanager\AdminBundle\Entity\CandidateJobRepository")
 */
class CandidateJob
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
     * @ORM\ManyToOne(targetEntity="Jobmanager\AdminBundle\Entity\Candidate")
     */
    private $candidate;

    /**
     * @ORM\ManyToOne(targetEntity="Jobmanager\AdminBundle\Entity\Job")
     */
    private $job;

    /**
     * @ORM\Column(name="name", type="string", nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;

    /**
     * @var
     *
     * @ORM\Column(name="updated_date", type="datetime", nullable=true)
     */
    private $updatedDate;

    /**
     * @ORM\Column(name="interest", type="text", nullable=true)
     */
    private $interest;

    /**
     * @ORM\Column(name="is_rejected", type="boolean", nullable=true)
     */
    private $isRejected;

    /**
     * @var
     *
     * @ORM\Column(name="is_outdated", type="boolean", nullable=true)
     */
    private $isOutdated;


    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return CandidateJob
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
     * Set interest
     *
     * @param string $interest
     * @return CandidateJob
     */
    public function setInterest($interest)
    {
        $this->interest = $interest;

        return $this;
    }

    /**
     * Get interest
     *
     * @return string 
     */
    public function getInterest()
    {
        return $this->interest;
    }

    /**
     * Set isRejected
     *
     * @param boolean $isRejected
     * @return CandidateJob
     */
    public function setIsRejected($isRejected)
    {
        $this->isRejected = $isRejected;

        return $this;
    }

    /**
     * Get isRejected
     *
     * @return boolean 
     */
    public function getIsRejected()
    {
        return $this->isRejected;
    }

    /**
     * Set candidate
     *
     * @param \Jobmanager\AdminBundle\Entity\Candidate $candidate
     * @return CandidateJob
     */
    public function setCandidate(\Jobmanager\AdminBundle\Entity\Candidate $candidate)
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

    /**
     * Set job
     *
     * @param \Jobmanager\AdminBundle\Entity\Job $job
     * @return CandidateJob
     */
    public function setJob(\Jobmanager\AdminBundle\Entity\Job $job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return \Jobmanager\AdminBundle\Entity\Job 
     */
    public function getJob()
    {
        return $this->job;
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
     * Set name
     *
     * @param string $name
     * @return CandidateJob
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
     * Set updatedDate
     *
     * @param \DateTime $updatedDate
     * @return CandidateJob
     */
    public function setUpdatedDate($updatedDate)
    {
        $this->updatedDate = $updatedDate;

        return $this;
    }

    /**
     * Get updatedDate
     *
     * @return \DateTime 
     */
    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }

    /**
     * Set isOutdated
     *
     * @param boolean $isOutdated
     * @return CandidateJob
     */
    public function setIsOutdated($isOutdated)
    {
        $this->isOutdated = $isOutdated;

        return $this;
    }

    /**
     * Get isOutdated
     *
     * @return boolean 
     */
    public function getIsOutdated()
    {
        return $this->isOutdated;
    }
}
