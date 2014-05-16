<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Techtest
 *
 * @ORM\Table(name="techtest")
 * @ORM\Entity(repositoryClass="Jobmanager\AdminBundle\Entity\TechtestRepository")
 */
class Techtest
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
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="techno", type="string", length=255, nullable=true)
     */
    private $techno;

    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer", nullable=true)
     */
    private $note;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Jobmanager\AdminBundle\Entity\Meeting")
     * @ORM\JoinColumn(nullable=true)
     */
    private $meeting;



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
     * Set type
     *
     * @param string $type
     * @return Techtest
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set techno
     *
     * @param string $techno
     * @return Techtest
     */
    public function setTechno($techno)
    {
        $this->techno = $techno;

        return $this;
    }

    /**
     * Get techno
     *
     * @return string 
     */
    public function getTechno()
    {
        return $this->techno;
    }

    /**
     * Set note
     *
     * @param integer $note
     * @return Techtest
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set meeting
     *
     * @param \Jobmanager\AdminBundle\Entity\Meeting $meeting
     * @return Techtest
     */
    public function setMeeting(\Jobmanager\AdminBundle\Entity\Meeting $meeting = null)
    {
        $this->meeting = $meeting;

        return $this;
    }

    /**
     * Get meeting
     *
     * @return \Jobmanager\AdminBundle\Entity\Meeting 
     */
    public function getMeeting()
    {
        return $this->meeting;
    }
}
