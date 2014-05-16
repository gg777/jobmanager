<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobSource
 *
 * @ORM\Table(name="job_source")
 * @ORM\Entity(repositoryClass="Jobmanager\AdminBundle\Entity\JobSourceRepository")
 */
class JobSource
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
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="url_doc_api", type="string", length=255, nullable=true)
     */
    private $urlDocApi;


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
     * @return JobSource
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
     * @return JobSource
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

    /**
     * Set urlDocApi
     *
     * @param string $urlDocApi
     * @return JobSource
     */
    public function setUrlDocApi($urlDocApi)
    {
        $this->urlDocApi = $urlDocApi;

        return $this;
    }

    /**
     * Get urlDocApi
     *
     * @return string 
     */
    public function getUrlDocApi()
    {
        return $this->urlDocApi;
    }
}
