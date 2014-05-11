<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Company
 *
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="JobManager\AdminBundle\Entity\CompanyRepository")
 */
class Company
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var integer
     *
     * @ORM\Column(name="zip", type="integer", nullable=true)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="lat", type="float", nullable=true)
     */
    private $lat;

    /**
     * @var string
     *
     * @ORM\Column(name="lng", type="float", nullable=true)
     */
    private $lng;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_head_hunter", type="boolean", nullable=true)
     */
    private $is_head_hunter;

    /**
     * @var string
     *
     * @ORM\Column(name="url_company", type="string", length=255, nullable=true)
     */
    private $urlCompany;

    /**
     * @var
     *
     * @ORM\OneToOne(targetEntity="Jobmanager\AdminBundle\Entity\Recruiter", cascade={"persist"})
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
     * Set name
     *
     * @param string $name
     * @return Company
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
     * Set address
     *
     * @param string $address
     * @return Company
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
     * @return Company
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
     * @return Company
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
     * Set country
     *
     * @param string $country
     * @return Company
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set urlCompany
     *
     * @param string $urlCompany
     * @return Company
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
     * Constructor
     */
    public function __construct()
    {
        $this->jobs = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set lat
     *
     * @param float $lat
     * @return Company
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return float 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param float $lng
     * @return Company
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return float 
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set is_head_hunter
     *
     * @param \bool $isHeadHunter
     * @return Company
     */
    public function setIsHeadHunter($isHeadHunter)
    {
        $this->is_head_hunter = $isHeadHunter;

        return $this;
    }

    /**
     * Get is_head_hunter
     *
     * @return \bool 
     */
    public function getIsHeadHunter()
    {
        return $this->is_head_hunter;
    }

    /**
     * Set recruiter
     *
     * @param \Jobmanager\AdminBundle\Entity\Recruiter $recruiter
     * @return Company
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
