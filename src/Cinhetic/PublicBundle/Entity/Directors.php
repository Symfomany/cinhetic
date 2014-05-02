<?php

namespace Cinhetic\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * Directors
 *
 * @ORM\Table(name="directors")
 * @ORM\Entity(repositoryClass="Cinhetic\PublicBundle\Repository\DirectorsRepository")
 * @UniqueEntity(fields={"firstname","lastname"}, message="Le titre est deja pris!")
 * @ExclusionPolicy("all")
 */
class Directors
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
     * @var string
     * @Expose
     * @Assert\Length(
     *      min = "3",
     *      max = "500",
     *      minMessage = "Votre prénom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre prénom ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="firstname", type="string", length=250, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     * @Expose
     * @Assert\Length(
     *      min = "3",
     *      max = "500",
     *      minMessage = "Votre nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre nom ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="lastname", type="string", length=250, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     * @Expose
     * @Assert\Length(
     *      min = "15",
     *      max = "500",
     *      minMessage = "Votre biographie doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre biographie ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="biography", type="text", nullable=true)
     */
    private $biography;

    /**
     * @var float
     * @Expose
     * @Assert\Range(
     *      min = 1,
     *      max = 5,
     *      minMessage = "Votre note doit etre entre 1 et 5",
     *      maxMessage = "Votre note doit etre entre 1 et 5"
     * )
     * @ORM\Column(name="note", type="float", precision=10, scale=0, nullable=true)
     */
    private $note;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Movies", inversedBy="directors")
     * @ORM\JoinTable(name="directors_movies",
     *   joinColumns={
     *     @ORM\JoinColumn(name="directors_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="movies_id", referencedColumnName="id")
     *   }
     * )
     */
    private $movies;

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
     * Set firstname
     *
     * @param string $firstname
     * @return Directors
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
     * @return Directors
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
     * Set biography
     *
     * @param string $biography
     * @return Directors
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;

        return $this;
    }

    /**
     * Get biography
     *
     * @return string 
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * Set note
     *
     * @param float $note
     * @return Directors
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return float 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Directors
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
     * @return Directors
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
        return $this->firstname." ".$this->lastname;
    }
}
