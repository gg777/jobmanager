<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recall
 *
 * @ORM\Table(name="recall")
 * @ORM\Entity(repositoryClass="Jobmanager\AdminBundle\Entity\RecallRepository")
 */
class Recall
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
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_first_contact", type="boolean", nullable=true)
     */
    private $isFirstContact;

    /**
     * @var
     *
     * @ORM\Column(name="source", type="string", length=255, nullable=true)
     */
    private $source;

    /**
     * @var
     *
     * @ORM\Column(name="is_recalled", type="boolean", nullable=true)
     */
    private $isRecalled;

    /**
     * @var
     *
     * @ORM\Column(name="recall_date", type="datetime", nullable=true)
     */
    private $recallDate;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Jobmanager\AdminBundle\Entity\JobSource")
     */
    private $jobSource;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Jobmanager\AdminBundle\Entity\Recruiter")
     */
    private $recruiter;


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
     * @return Recall
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
     * Set isFirstContact
     *
     * @param boolean $isFirstContact
     * @return Recall
     */
    public function setIsFirstContact($isFirstContact)
    {
        $this->isFirstContact = $isFirstContact;

        return $this;
    }

    /**
     * Get isFirstContact
     *
     * @return boolean 
     */
    public function getIsFirstContact()
    {
        return $this->isFirstContact;
    }

    /**
     * Set recruiter
     *
     * @param \Jobmanager\AdminBundle\Entity\Recruiter $recruiter
     * @return Recall
     */
    public function setRecruiter(\Jobmanager\AdminBundle\Entity\Recruiter $recruiter = null)
    {
        $this->recruiter = $recruiter;

        return $this;
    }

    /**
     * Get recruiter
     *
     * @return \Jobmanager\AdminBundle\Entity\Recruiter 
     */
    public function getRecruiter()
    {
        return $this->recruiter;
    }

    /**
     * Set source
     *
     * @param string $source
     * @return Recall
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set jobSource
     *
     * @param \Jobmanager\AdminBundle\Entity\JobSource $jobSource
     * @return Recall
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
     * Set isRecalled
     *
     * @param boolean $isRecalled
     * @return Recall
     */
    public function setIsRecalled($isRecalled)
    {
        $this->isRecalled = $isRecalled;

        return $this;
    }

    /**
     * Get isRecalled
     *
     * @return boolean 
     */
    public function getIsRecalled()
    {
        return $this->isRecalled;
    }

    /**
     * Set recallDate
     *
     * @param \DateTime $recallDate
     * @return Recall
     */
    public function setRecallDate($recallDate)
    {
        $this->recallDate = $recallDate;

        return $this;
    }

    /**
     * Get recallDate
     *
     * @return \DateTime 
     */
    public function getRecallDate()
    {
        return $this->recallDate;
    }
}
