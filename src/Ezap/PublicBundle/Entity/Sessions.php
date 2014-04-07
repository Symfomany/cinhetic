<?php

namespace Ezap\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sessions
 *
 * @ORM\Table(name="sessions", indexes={@ORM\Index(name="movies_id", columns={"movies_id"})})
 * @ORM\Entity(repositoryClass="Ezap\PublicBundle\Repository\SessionRepository")
 */
class Sessions
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
     * @ORM\Column(name="date_session", type="datetime", nullable=true)
     */
    private $dateSession;

    /**
     * @var \Movies
     *
     * @ORM\ManyToOne(targetEntity="Movies")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="movies_id", referencedColumnName="id")
     * })
     */
    private $movies;


    /**
     * @var \Movies
     *
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
     * @param \Ezap\PublicBundle\Entity\Movies $movies
     * @return Sessions
     */
    public function setMovies(\Ezap\PublicBundle\Entity\Movies $movies = null)
    {
        $this->movies = $movies;

        return $this;
    }

    /**
     * Get movies
     *
     * @return \Ezap\PublicBundle\Entity\Movies 
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
     * @param \Ezap\PublicBundle\Entity\Cinema $cinema
     * @return Sessions
     */
    public function setCinema(\Ezap\PublicBundle\Entity\Cinema $cinema = null)
    {
        $this->cinema = $cinema;

        return $this;
    }

    /**
     * Get cinema
     *
     * @return \Ezap\PublicBundle\Entity\Cinema 
     */
    public function getCinema()
    {
        return $this->cinema;
    }
}
