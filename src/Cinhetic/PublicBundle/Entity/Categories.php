<?php

namespace Cinhetic\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations

/**
 * Categories
 * @ORM\Table(name="categories")
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity(repositoryClass="Cinhetic\PublicBundle\Repository\CategoriesRepository")
 * @UniqueEntity(fields="title", message="Le titre est deja pris!")
 */
class Categories
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
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "10",
     *      max = "200",
     *      minMessage = "Votre titre doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre titre ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="title", type="string", length=250, nullable=true)
     */
    private $title;



    /**
     * @Gedmo\Slug(fields={"title"}, updatable=false, separator="-")
     * @ORM\Column(name="slug", type="string", length=250, nullable=true)
     */
    private $slug;


    /**
     * @var string
     * @Assert\Length(
     *      min = "50",
     *      max = "1500",
     *      minMessage = "Votre description doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre description ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    private $dateCreated;



    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="date_updated", type="datetime", nullable=true)
     */
    private $dateUpdated;

    /**
     * @ORM\OneToMany(targetEntity="Movies", mappedBy="category")
     */
    protected $movies;


    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    private $position;


    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer",nullable=true)
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer",nullable=true)
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer",nullable=true)
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Categories", inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Categories", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;
    
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
     * @return Categories
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
     * Set description
     *
     * @param string $description
     * @return Categories
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Categories
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
     * @return string
     */
    public function __toString(){
        return $this->title;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->movies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dateCreated = new \Datetime('now');
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add movies
     *
     * @param \Cinhetic\PublicBundle\Entity\Movies $movies
     * @return Categories
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
     * Set slug
     *
     * @param string $slug
     * @return Movies
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Categories
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set lft
     *
     * @param integer $lft
     * @return Categories
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer 
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     * @return Categories
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     * @return Categories
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer 
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set root
     *
     * @param integer $root
     * @return Categories
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return integer 
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set parent
     *
     * @param \Cinhetic\PublicBundle\Entity\Categories $parent
     * @return Categories
     */
    public function setParent(\Cinhetic\PublicBundle\Entity\Categories $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Cinhetic\PublicBundle\Entity\Categories
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \Cinhetic\PublicBundle\Entity\Categories $children
     * @return Categories
     */
    public function addChild(\Cinhetic\PublicBundle\Entity\Categories $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Cinhetic\PublicBundle\Entity\Categories $children
     */
    public function removeChild(\Cinhetic\PublicBundle\Entity\Categories $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Get Option for choices
     * @return string
     */
    public function getOptionLabel()
    {
        return str_repeat(
            html_entity_decode('...', ENT_QUOTES, 'UTF-8'),
            ($this->getLvl() + 1) * 2
        ) . $this->getTitle();
    }

}
