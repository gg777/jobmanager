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
     * @ORM\id
     * @ORM\ManyToOne(targetEntity="Jobmanager\AdminBundle\Entity\Candidate")
     */
    private $candidate;

    /**
     * @ORM\id
     * @ORM\ManyToOne(targetEntity="Jobmanager\AdminBundle\Entity\Job")
     */
    private $job;

    /**
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;

    /**
     * @ORM\Column(name="interest", type="text", nullable=true)
     */
    private $interest;

    /**
     * @ORM\Column(name="is_applied", type="boolean", nullable=true)
     */
    private $isApplied;

    /**
     * @ORM\Column(name="is_rejected", type="boolean", nullable=true)
     */
    private $isRejected;


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
     * Set isApplied
     *
     * @param boolean $isApplied
     * @return CandidateJob
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
}
