<?php

namespace Ezap\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Medias
 *
 * @ORM\Table(name="medias", indexes={@ORM\Index(name="movies_id", columns={"movies_id"})})
 * @ORM\Entity
 */
class Medias
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
     * @var integer
     *
     * @ORM\Column(name="nature", type="integer", nullable=true)
     */
    private $nature;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="text", nullable=true)
     */
    private $picture;

    /**
     * @var string
     *
     * @ORM\Column(name="video", type="text", nullable=true)
     */
    private $video;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToOne(targetEntity="Movies", inversedBy="medias")
     */
    private $movies;


    /**
     * @var \User
     * @ORM\ManyToOne(targetEntity="Movies")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="movies_id", referencedColumnName="id")
     * })
     */
    private $movie;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateCreated = new \Datetime('now');

    }


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
     * Set moviesId
     *
     * @param integer $moviesId
     * @return Medias
     */
    public function setMoviesId($moviesId)
    {
        $this->moviesId = $moviesId;

        return $this;
    }

    /**
     * Get moviesId
     *
     * @return integer 
     */
    public function getMoviesId()
    {
        return $this->moviesId;
    }

    /**
     * Set nature
     *
     * @param integer $nature
     * @return Medias
     */
    public function setNature($nature)
    {
        $this->nature = $nature;

        return $this;
    }

    /**
     * Get nature
     *
     * @return integer 
     */
    public function getNature()
    {
        return $this->nature;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return Medias
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set video
     *
     * @param string $video
     * @return Medias
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string 
     */
    public function getVideo()
    {
        return $this->video;
    }


    /**
     * Add movies
     *
     * @param \Ezap\PublicBundle\Entity\Movies $movies
     * @return Medias
     */
    public function addMovie(\Ezap\PublicBundle\Entity\Movies $movies)
    {
        $this->movies[] = $movies;

        return $this;
    }

    /**
     * Remove movies
     *
     * @param \Ezap\PublicBundle\Entity\Movies $movies
     */
    public function removeMovie(\Ezap\PublicBundle\Entity\Movies $movies)
    {
        $this->movies->removeElement($movies);
    }

    /**
     * Get movies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovies()
    {
        return $this->movies;
    }

    /**
     * Set movies
     *
     * @param \Ezap\PublicBundle\Entity\Movies $movies
     * @return Medias
     */
    public function setMovies(\Ezap\PublicBundle\Entity\Movies $movies = null)
    {
        $this->movies = $movies;

        return $this;
    }

    /**
     * Set movie
     *
     * @param \Ezap\PublicBundle\Entity\Movies $movie
     * @return Medias
     */
    public function setMovie(\Ezap\PublicBundle\Entity\Movies $movie = null)
    {
        $this->movie = $movie;

        return $this;
    }

    /**
     * Get movie
     *
     * @return \Ezap\PublicBundle\Entity\Movies
     */
    public function getMovie()
    {
        return $this->movie;
    }


    /**
     * @return string
     */
    public function __toString(){
        return $this->picture;
    }
}
