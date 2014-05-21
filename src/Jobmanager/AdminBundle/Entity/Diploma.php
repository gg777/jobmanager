<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Diploma
 *
 * @ORM\Table(name="diploma")
 * @ORM\Entity(repositoryClass="Jobmanager\AdminBundle\Entity\DiplomaRepository")
 */
class Diploma
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Jobmanager\AdminBundle\Entity\Formation")
     */
    private $formation;


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
     * @return Diploma
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
     * Set date
     *
     * @param \DateTime $date
     * @return Diploma
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * Set formation
     *
     * @param \Jobmanager\AdminBundle\Entity\Formation $formation
     * @return Diploma
     */
    public function setFormation(\Jobmanager\AdminBundle\Entity\Formation $formation = null)
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * Get formation
     *
     * @return \Jobmanager\AdminBundle\Entity\Formation 
     */
    public function getFormation()
    {
        return $this->formation;
    }
}
