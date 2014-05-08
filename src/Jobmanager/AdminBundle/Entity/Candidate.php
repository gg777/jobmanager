<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidate
 *
 * @ORM\Table(name="candidate")
 * @ORM\Entity(repositoryClass="Jobmanager\AdminBundle\Entity\CandidateRepository")
 */
class Candidate
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
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var integer
     *
     * @ORM\Column(name="zip", type="integer")
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date")
     */
    private $birthdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime")
     */
    private $createdDate;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Jobmanager\AdminBundle\Entity\Competence", inversedBy="candidates")
     */
    private $competences;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Jobmanager\AdminBundle\Entity\Language", inversedBy="candidates")
     */
    private $languages;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Jobmanager\AdminBundle\Entity\Diploma", inversedBy="candidates")
     */
    private $diplomas;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Jobmanager\AdminBundle\Entity\Formation", inversedBy="candidates")
     */
    private $formations;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Jobmanager\AdminBundle\Entity\Cv", inversedBy="candidates")
     */
    private $cvs;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Jobmanager\AdminBundle\Entity\Motivation", inversedBy="candidates")
     */
    private $motivations;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Jobmanager\AdminBundle\Entity\JobExperience", inversedBy="candidates")
     */
    private $jobExperiences;

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
     * Set firstname
     *
     * @param string $firstname
     * @return Candidate
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Candidate
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return Candidate
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Candidate
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Candidate
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zip
     *
     * @param integer $zip
     * @return Candidate
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return integer 
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Candidate
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return Candidate
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Candidate
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
        $this->competences = new \Doctrine\Common\Collections\ArrayCollection();
        $this->languages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->diplomas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cvs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->motivations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->jobExperiences = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add competences
     *
     * @param \Jobmanager\AdminBundle\Entity\Competence $competences
     * @return Candidate
     */
    public function addCompetence(\Jobmanager\AdminBundle\Entity\Competence $competences)
    {
        $this->competences[] = $competences;

        return $this;
    }

    /**
     * Remove competences
     *
     * @param \Jobmanager\AdminBundle\Entity\Competence $competences
     */
    public function removeCompetence(\Jobmanager\AdminBundle\Entity\Competence $competences)
    {
        $this->competences->removeElement($competences);
    }

    /**
     * Get competences
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCompetences()
    {
        return $this->competences;
    }

    /**
     * Add languages
     *
     * @param \Jobmanager\AdminBundle\Entity\Language $languages
     * @return Candidate
     */
    public function addLanguage(\Jobmanager\AdminBundle\Entity\Language $languages)
    {
        $this->languages[] = $languages;

        return $this;
    }

    /**
     * Remove languages
     *
     * @param \Jobmanager\AdminBundle\Entity\Language $languages
     */
    public function removeLanguage(\Jobmanager\AdminBundle\Entity\Language $languages)
    {
        $this->languages->removeElement($languages);
    }

    /**
     * Get languages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Add diplomas
     *
     * @param \Jobmanager\AdminBundle\Entity\Diploma $diplomas
     * @return Candidate
     */
    public function addDiploma(\Jobmanager\AdminBundle\Entity\Diploma $diplomas)
    {
        $this->diplomas[] = $diplomas;

        return $this;
    }

    /**
     * Remove diplomas
     *
     * @param \Jobmanager\AdminBundle\Entity\Diploma $diplomas
     */
    public function removeDiploma(\Jobmanager\AdminBundle\Entity\Diploma $diplomas)
    {
        $this->diplomas->removeElement($diplomas);
    }

    /**
     * Get diplomas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDiplomas()
    {
        return $this->diplomas;
    }

    /**
     * Add formations
     *
     * @param \Jobmanager\AdminBundle\Entity\Formation $formations
     * @return Candidate
     */
    public function addFormation(\Jobmanager\AdminBundle\Entity\Formation $formations)
    {
        $this->formations[] = $formations;

        return $this;
    }

    /**
     * Remove formations
     *
     * @param \Jobmanager\AdminBundle\Entity\Formation $formations
     */
    public function removeFormation(\Jobmanager\AdminBundle\Entity\Formation $formations)
    {
        $this->formations->removeElement($formations);
    }

    /**
     * Get formations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormations()
    {
        return $this->formations;
    }

    /**
     * Add cvs
     *
     * @param \Jobmanager\AdminBundle\Entity\Cv $cvs
     * @return Candidate
     */
    public function addCv(\Jobmanager\AdminBundle\Entity\Cv $cvs)
    {
        $this->cvs[] = $cvs;

        return $this;
    }

    /**
     * Remove cvs
     *
     * @param \Jobmanager\AdminBundle\Entity\Cv $cvs
     */
    public function removeCv(\Jobmanager\AdminBundle\Entity\Cv $cvs)
    {
        $this->cvs->removeElement($cvs);
    }

    /**
     * Get cvs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCvs()
    {
        return $this->cvs;
    }

    /**
     * Add motivations
     *
     * @param \Jobmanager\AdminBundle\Entity\Motivation $motivations
     * @return Candidate
     */
    public function addMotivation(\Jobmanager\AdminBundle\Entity\Motivation $motivations)
    {
        $this->motivations[] = $motivations;

        return $this;
    }

    /**
     * Remove motivations
     *
     * @param \Jobmanager\AdminBundle\Entity\Motivation $motivations
     */
    public function removeMotivation(\Jobmanager\AdminBundle\Entity\Motivation $motivations)
    {
        $this->motivations->removeElement($motivations);
    }

    /**
     * Get motivations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMotivations()
    {
        return $this->motivations;
    }

    /**
     * Add jobExperiences
     *
     * @param \Jobmanager\AdminBundle\Entity\JobExperience $jobExperiences
     * @return Candidate
     */
    public function addJobExperience(\Jobmanager\AdminBundle\Entity\JobExperience $jobExperiences)
    {
        $this->jobExperiences[] = $jobExperiences;

        return $this;
    }

    /**
     * Remove jobExperiences
     *
     * @param \Jobmanager\AdminBundle\Entity\JobExperience $jobExperiences
     */
    public function removeJobExperience(\Jobmanager\AdminBundle\Entity\JobExperience $jobExperiences)
    {
        $this->jobExperiences->removeElement($jobExperiences);
    }

    /**
     * Get jobExperiences
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getJobExperiences()
    {
        return $this->jobExperiences;
    }
}
