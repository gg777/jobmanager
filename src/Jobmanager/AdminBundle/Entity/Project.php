<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="Jobmanager\AdminBundle\Entity\ProjectRepository")
 */
class Project
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
     * @ORM\Column(name="name", type="string", nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="domain_intervention", type="text", nullable=true)
     */
    private $domainIntervention;

    /**
     * @var string
     *
     * @ORM\Column(name="technical_environnement", type="text", nullable=true)
     */
    private $technicalEnvironnement;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Jobmanager\AdminBundle\Entity\JobExperience")
     */
    private $jobExperience;

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
     * Set domainIntervention
     *
     * @param string $domainIntervention
     * @return Project
     */
    public function setDomainIntervention($domainIntervention)
    {
        $this->domainIntervention = $domainIntervention;

        return $this;
    }

    /**
     * Get domainIntervention
     *
     * @return string 
     */
    public function getDomainIntervention()
    {
        return $this->domainIntervention;
    }

    /**
     * Set technicalEnvironnement
     *
     * @param string $technicalEnvironnement
     * @return Project
     */
    public function setTechnicalEnvironnement($technicalEnvironnement)
    {
        $this->technicalEnvironnement = $technicalEnvironnement;

        return $this;
    }

    /**
     * Get technicalEnvironnement
     *
     * @return string 
     */
    public function getTechnicalEnvironnement()
    {
        return $this->technicalEnvironnement;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Project
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
     * Set jobExperience
     *
     * @param \Jobmanager\AdminBundle\Entity\JobExperience $jobExperience
     * @return Project
     */
    public function setJobExperience(\Jobmanager\AdminBundle\Entity\JobExperience $jobExperience = null)
    {
        $this->jobExperience = $jobExperience;

        return $this;
    }

    /**
     * Get jobExperience
     *
     * @return \Jobmanager\AdminBundle\Entity\JobExperience 
     */
    public function getJobExperience()
    {
        return $this->jobExperience;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Project
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
     * Set url
     *
     * @param string $url
     * @return Project
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }
}
