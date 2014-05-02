<?php

namespace Cinhetic\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Sessions
 * @ORM\Table(name="sessions", indexes={@ORM\Index(name="movies_id", columns={"movies_id"})})
 * @ORM\Entity(repositoryClass="Cinhetic\PublicBundle\Repository\SessionsRepository")
 * @ExclusionPolicy("all")
 */
class Sessions
{
    /**
     * @var integer
     * @Expose
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @Expose
     * @var \DateTime
     * @ORM\Column(name="date_session", type="datetime", nullable=true)
     */
    private $dateSession;

    /**
     * @var \Movies
     * @Expose
     * @ORM\ManyToOne(targetEntity="Movies")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="movies_id", referencedColumnName="id")
     * })
     */
    private $movies;


    /**
     * @var \Movies
     * @Expose
     * @ORM\ManyToOne(targetEntity="Cinema", inversedBy="sessions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cinema_id", referencedColumnName="id")
     * })
     */
    private $cinema;



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
     * Set dateSession
     *
     * @param \DateTime $dateSession
     * @return Sessions
     */
    public function setDateSession($dateSession)
    {
        $this->dateSession = $dateSession;

        return $this;
    }

    /**
     * Get dateSession
     *
     * @return \DateTime 
     */
    public function getDateSession()
    {
        return $this->dateSession;
    }

    /**
     * Set movies
     *
     * @param \Cinhetic\PublicBundle\Entity\Movies $movies
     * @return Sessions
     */
    public function setMovies(\Cinhetic\PublicBundle\Entity\Movies $movies = null)
    {
        $this->movies = $movies;

        return $this;
    }

    /**
     * Get movies
     *
     * @return \Cinhetic\PublicBundle\Entity\Movies
     */
    public function getMovies()
    {
        return $this->movies;
    }


    /**
     * @return string
     */
    public function __toString(){
        return $this->dateSession;
    }

    /**
     * Set cinema
     *
     * @param \Cinhetic\PublicBundle\Entity\Cinema $cinema
     * @return Sessions
     */
    public function setCinema(\Cinhetic\PublicBundle\Entity\Cinema $cinema = null)
    {
        $this->cinema = $cinema;

        return $this;
    }

    /**
     * Get cinema
     *
     * @return \Cinhetic\PublicBundle\Entity\Cinema
     */
    public function getCinema()
    {
        return $this->cinema;
    }
}
