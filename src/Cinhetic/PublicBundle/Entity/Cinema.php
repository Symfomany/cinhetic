<?php

namespace Cinhetic\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * Cinema
 *
 * @ORM\Table(name="cinema")
 * @ORM\Entity(repositoryClass="Cinhetic\PublicBundle\Repository\CinemaRepository")
 * @UniqueEntity(fields="title", message="Le titre est deja pris!")
 * @ExclusionPolicy("all")
 */
class Cinema
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
     * @var string
     * @Assert\Length(
     *      min = "15",
     *      max = "1500",
     *      minMessage = "Votre titre doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre titre ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="title", type="string", length=250, nullable=true)
     */
    private $title;

    /**
     * @Expose
     * @var string
     * @Assert\Length(
     *      min = "2",
     *      max = "150",
     *      minMessage = "Votre ville doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre ville ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="ville", type="string", length=250, nullable=true)
     */
    private $ville;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @Expose
     * @ORM\ManyToMany(targetEntity="Movies", inversedBy="cinemas")
     * @ORM\JoinTable(name="cinema_movies",
     *   joinColumns={
     *     @ORM\JoinColumn(name="cinemas_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="movies_id", referencedColumnName="id")
     *   }
     * )
     */
    private $movies;


    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="Sessions", mappedBy="cinema")
     */
    private $sessions;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->movies = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Cinema
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Cinema
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Cinema
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Add movies
     *
     * @param \Cinhetic\PublicBundle\Entity\Movies $movies
     * @return Cinema
     */
    public function addMovie(\Cinhetic\PublicBundle\Entity\Movies $movies)
    {
        $this->movies[] = $movies;

        return $this;
    }

    /**
     * Remove movies
     *
     * @param \Cinhetic\PublicBundle\Entity\Movies $movies
     */
    public function removeMovie(\Cinhetic\PublicBundle\Entity\Movies $movies)
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
     * @return string
     */
    public function __toString(){
        return $this->title;
    }

    /**
     * Add sessions
     *
     * @param \Cinhetic\PublicBundle\Entity\Sessions $sessions
     * @return Cinema
     */
    public function addSession(\Cinhetic\PublicBundle\Entity\Sessions $sessions)
    {
        $this->sessions[] = $sessions;

        return $this;
    }

    /**
     * Remove sessions
     *
     * @param \Cinhetic\PublicBundle\Entity\Sessions $sessions
     */
    public function removeSession(\Cinhetic\PublicBundle\Entity\Sessions $sessions)
    {
        $this->sessions->removeElement($sessions);
    }

    /**
     * Get sessions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSessions()
    {
        return $this->sessions;
    }
}
