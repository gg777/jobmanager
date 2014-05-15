<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fonecall
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Jobmanager\AdminBundle\Entity\FonecallRepository")
 */
class Fonecall
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
     * @ORM\Column(name="date_begin", type="datetime")
     */
    private $dateBegin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_end", type="datetime")
     */
    private $dateEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isInbound", type="boolean")
     */
    private $isInbound;

    /**
     * @var string
     *
     * @ORM\Column(name="sousource", type="string", length=255)
     */
    private $sousource;


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
     * Set dateBegin
     *
     * @param \DateTime $dateBegin
     * @return Fonecall
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
     * @return Fonecall
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
     * Set type
     *
     * @param string $type
     * @return Fonecall
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
     * Set description
     *
     * @param string $description
     * @return Fonecall
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
     * Set isInbound
     *
     * @param boolean $isInbound
     * @return Fonecall
     */
    public function setIsInbound($isInbound)
    {
        $this->isInbound = $isInbound;

        return $this;
    }

    /**
     * Get isInbound
     *
     * @return boolean 
     */
    public function getIsInbound()
    {
        return $this->isInbound;
    }

    /**
     * Set sousource
     *
     * @param string $sousource
     * @return Fonecall
     */
    public function setSousource($sousource)
    {
        $this->sousource = $sousource;

        return $this;
    }

    /**
     * Get sousource
     *
     * @return string 
     */
    public function getSousource()
    {
        return $this->sousource;
    }
}
