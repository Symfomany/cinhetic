<?php

namespace Cinhetic\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Tags
 * @ExclusionPolicy("all")
 * @ORM\Table(name="tags")
 * @ORM\Entity(repositoryClass="Cinhetic\PublicBundle\Repository\TagsRepository")
 * @UniqueEntity(fields="word", message="Le mots-clef existe déjà")
 */
class Tags
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
     *      min = "3",
     *      max = "50",
     *      minMessage = "Votre mots-clefs doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre mots-clefs ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="word", type="string", length=400, nullable=true)
     */
    private $word;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Movies", inversedBy="tags")
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
     * Set word
     *
     * @param string $word
     * @return Tags
     */
    public function setWord($word)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * Get word
     *
     * @return string 
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * Add movies
     *
     * @param \Cinhetic\PublicBundle\Entity\Medias $movies
     * @return Tags
     */
    public function addMovie(\Cinhetic\PublicBundle\Entity\Medias $movies)
    {
        $this->movies[] = $movies;

        return $this;
    }

    /**
     * Remove movies
     *
     * @param \Cinhetic\PublicBundle\Entity\Medias $movies
     */
    public function removeMovie(\Cinhetic\PublicBundle\Entity\Medias $movies)
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
        return $this->word;
    }
}
