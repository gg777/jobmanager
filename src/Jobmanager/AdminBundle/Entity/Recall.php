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
     * @ORM\Column(name="created_date", type="datetime")
     */
    private $createdDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_first_contact", type="boolean")
     */
    private $isFirstContact;

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
}
