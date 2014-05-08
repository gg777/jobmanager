<?php
// src/Jobmanager/AdminBundle/Entity/CandidateJob.php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CandidateJob
 * @package Jobmanager\AdminBundle\Entity
 * @ORM\Entity
 * @ORM\Table("candidate_job")
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
     * @ORM\Column(name="created_date", type="datetime")
     */
    private $createdDate;

    /**
     * @ORM\Column(name="interest", type="text")
     */
    private $interest;

    /**
     * @ORM\Column(name="is_applied", type="boolean")
     */
    private $isApplied;

    /**
     * @ORM\Column(name="date_meeting", type="datetime")
     */
    private $dateMeeting;

    /**
     * @ORM\Column(name="is_rejected", type="boolean")
     */
    private $isRejected;
} 