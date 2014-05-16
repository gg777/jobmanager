<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jobs
 *
 * @ORM\Table(name="jobs")
 * @ORM\Entity
 */
class Jobs
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=255, nullable=false)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=255, nullable=true)
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var integer
     *
     * @ORM\Column(name="zip", type="integer", nullable=true)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255, nullable=true)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="interest", type="text", nullable=true)
     */
    private $interest;

    /**
     * @var string
     *
     * @ORM\Column(name="url_company", type="string", length=255, nullable=true)
     */
    private $urlCompany;

    /**
     * @var string
     *
     * @ORM\Column(name="url_job", type="string", length=255, nullable=true)
     */
    private $urlJob;

    /**
     * @var boolean
     *
     * @ORM\Column(name="check", type="boolean", nullable=true)
     */
    private $check;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_firstname", type="string", length=255, nullable=true)
     */
    private $contactFirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_lastname", type="string", length=255, nullable=true)
     */
    private $contactLastname;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_genre", type="string", length=3, nullable=true)
     */
    private $contactGenre;

    /**
     * @var boolean
     *
     * @ORM\Column(name="check_website", type="boolean", nullable=true)
     */
    private $checkWebsite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_meeting_1", type="datetime", nullable=true)
     */
    private $dateMeeting1;

    /**
     * @var boolean
     *
     * @ORM\Column(name="out", type="boolean", nullable=true)
     */
    private $out;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255, nullable=true)
     */
    private $source;

    /**
     * @var boolean
     *
     * @ORM\Column(name="recall", type="boolean", nullable=true)
     */
    private $recall;

    /**
     * @var
     *
     * @ORM\Column(name="answer", type="string", length=255, nullable=true)
     */
    private $answer;

    /**
     * @var
     *
     * @ORM\Column(name="date_answer", type="date", nullable=true)
     */
    private $dateAnswer;

    /**
     * @var
     *
     * @ORM\Column(name="contact_inbound", type="boolean", nullable=true)
     */
    private $contactInBound;



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
     * Set date
     *
     * @param \DateTime $date
     * @return Jobs
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
     * Set company
     *
     * @param string $company
     * @return Jobs
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return Jobs
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Jobs
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
     * Set zip
     *
     * @param integer $zip
     * @return Jobs
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
     * Set email
     *
     * @param string $email
     * @return Jobs
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
     * Set tel
     *
     * @param string $tel
     * @return Jobs
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
     * Set interest
     *
     * @param string $interest
     * @return Jobs
     */
    public function setInterest($interest)
    {
        $this->interest = $interest;

        return $this;
    }

    /**
     * Get interest
     *
     * @return string 
     */
    public function getInterest()
    {
        return $this->interest;
    }

    /**
     * Set urlCompany
     *
     * @param string $urlCompany
     * @return Jobs
     */
    public function setUrlCompany($urlCompany)
    {
        $this->urlCompany = $urlCompany;

        return $this;
    }

    /**
     * Get urlCompany
     *
     * @return string 
     */
    public function getUrlCompany()
    {
        return $this->urlCompany;
    }

    /**
     * Set urlJob
     *
     * @param string $urlJob
     * @return Jobs
     */
    public function setUrlJob($urlJob)
    {
        $this->urlJob = $urlJob;

        return $this;
    }

    /**
     * Get urlJob
     *
     * @return string 
     */
    public function getUrlJob()
    {
        return $this->urlJob;
    }

    /**
     * Set check
     *
     * @param boolean $check
     * @return Jobs
     */
    public function setCheck($check)
    {
        $this->check = $check;

        return $this;
    }

    /**
     * Get check
     *
     * @return boolean 
     */
    public function getCheck()
    {
        return $this->check;
    }

    /**
     * Set contactFirstname
     *
     * @param string $contactFirstname
     * @return Jobs
     */
    public function setContactFirstname($contactFirstname)
    {
        $this->contactFirstname = $contactFirstname;

        return $this;
    }

    /**
     * Get contactFirstname
     *
     * @return string 
     */
    public function getContactFirstname()
    {
        return $this->contactFirstname;
    }

    /**
     * Set contactLastname
     *
     * @param string $contactLastname
     * @return Jobs
     */
    public function setContactLastname($contactLastname)
    {
        $this->contactLastname = $contactLastname;

        return $this;
    }

    /**
     * Get contactLastname
     *
     * @return string 
     */
    public function getContactLastname()
    {
        return $this->contactLastname;
    }

    /**
     * Set contactGenre
     *
     * @param string $contactGenre
     * @return Jobs
     */
    public function setContactGenre($contactGenre)
    {
        $this->contactGenre = $contactGenre;

        return $this;
    }

    /**
     * Get contactGenre
     *
     * @return string 
     */
    public function getContactGenre()
    {
        return $this->contactGenre;
    }

    /**
     * Set checkWebsite
     *
     * @param boolean $checkWebsite
     * @return Jobs
     */
    public function setCheckWebsite($checkWebsite)
    {
        $this->checkWebsite = $checkWebsite;

        return $this;
    }

    /**
     * Get checkWebsite
     *
     * @return boolean 
     */
    public function getCheckWebsite()
    {
        return $this->checkWebsite;
    }

    /**
     * Set dateMeeting1
     *
     * @param \DateTime $dateMeeting1
     * @return Jobs
     */
    public function setDateMeeting1($dateMeeting1)
    {
        $this->dateMeeting1 = $dateMeeting1;

        return $this;
    }

    /**
     * Get dateMeeting1
     *
     * @return \DateTime 
     */
    public function getDateMeeting1()
    {
        return $this->dateMeeting1;
    }

    /**
     * Set out
     *
     * @param boolean $out
     * @return Jobs
     */
    public function setOut($out)
    {
        $this->out = $out;

        return $this;
    }

    /**
     * Get out
     *
     * @return boolean 
     */
    public function getOut()
    {
        return $this->out;
    }

    /**
     * Set source
     *
     * @param string $source
     * @return Jobs
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
     * Set recall
     *
     * @param boolean $recall
     * @return Jobs
     */
    public function setRecall($recall)
    {
        $this->recall = $recall;

        return $this;
    }

    /**
     * Get recall
     *
     * @return boolean 
     */
    public function getRecall()
    {
        return $this->recall;
    }

    /**
     * Set answer
     *
     * @param string $answer
     * @return Jobs
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set dateAnswer
     *
     * @param \DateTime $dateAnswer
     * @return Jobs
     */
    public function setDateAnswer($dateAnswer)
    {
        $this->dateAnswer = $dateAnswer;

        return $this;
    }

    /**
     * Get dateAnswer
     *
     * @return \DateTime 
     */
    public function getDateAnswer()
    {
        return $this->dateAnswer;
    }

    /**
     * Set contactInBound
     *
     * @param boolean $contactInBound
     * @return Jobs
     */
    public function setContactInBound($contactInBound)
    {
        $this->contactInBound = $contactInBound;

        return $this;
    }

    /**
     * Get contactInBound
     *
     * @return boolean 
     */
    public function getContactInBound()
    {
        return $this->contactInBound;
    }
}
