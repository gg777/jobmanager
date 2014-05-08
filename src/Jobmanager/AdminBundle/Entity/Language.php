<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Language
 *
 * @ORM\Table(name="language")
 * @ORM\Entity(repositoryClass="Jobmanager\AdminBundle\Entity\LanguageRepository")
 */
class Language
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
     * @var integer
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Jobmanager\AdminBundle\Entity\Candidate", mappedBy="languages")
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
     * @return Language
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
     * Set level
     *
     * @param integer $level
     * @return Language
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
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
     * @return Language
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
