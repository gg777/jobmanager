<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cv
 *
 * @ORM\Table(name="cv")
 * @ORM\Entity(repositoryClass="Jobmanager\AdminBundle\Entity\CvRepository")
 */
class Cv
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime")
     */
    private $createdDate;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Jobmanager\AdminBundle\Entity\Candidate", mappedBy="cvs")
     */
    private $candidates;


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
     * @return Cv
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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Cv
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
     * Constructor
     */
    public function __construct()
    {
        $this->candidates = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add candidates
     *
     * @param \Jobmanager\AdminBundle\Entity\Candidate $candidates
     * @return Cv
     */
    public function addCandidate(\Jobmanager\AdminBundle\Entity\Candidate $candidates)
    {
        $this->candidates[] = $candidates;

        return $this;
    }

    /**
     * Remove candidates
     *
     * @param \Jobmanager\AdminBundle\Entity\Candidate $candidates
     */
    public function removeCandidate(\Jobmanager\AdminBundle\Entity\Candidate $candidates)
    {
        $this->candidates->removeElement($candidates);
    }

    /**
     * Get candidates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCandidates()
    {
        return $this->candidates;
    }
}