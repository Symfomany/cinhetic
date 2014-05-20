<?php

namespace Cinhetic\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Actors
 * @ExclusionPolicy("all")
 * @ORM\Table(name="actors")
 * @ORM\Entity(repositoryClass="Cinhetic\PublicBundle\Repository\ActorsRepository")
 * @UniqueEntity(fields={"firstname","lastname"}, message="Le titre est deja pris!")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\SoftDeleteable(fieldName="dateDeleted")
 */
class Actors implements UploadableInterface
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
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = "3",
     *      max = "500",
     *      minMessage = "Votre prénom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre prénom ne peut pas être plus long que {{ limit }} caractères"
     *   
     * )
     * @ORM\Column(name="firstname", type="string", length=250, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     * @Expose
     * @Assert\NotBlank
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
     * @Gedmo\Slug(fields={"firstname", "lastname"}, updatable=false, separator="-")
     * @ORM\Column(name="slug", type="string", length=250, nullable=true)
     */
    private $slug;

    /**
     * @var string
     * @Expose
     * @ORM\Column(name="dob", type="date", nullable=true)
     */
    private $dob;

    /**
     * @var string
     * @Assert\Length(
     *      min = "3",
     *      max = "50",
     *      minMessage = "Votre ville doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre ville ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="city", type="string", length=250, nullable=true)
     */
    private $city;

    /**
     * @Expose
     * @var string
     * @Assert\Length(
     *      min = "2",
     *      max = "50",
     *      minMessage = "Votre nationalité doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre nationalité ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="nationality", type="string", length=250, nullable=true)
     */
    private $nationality;

    /**
     * @Expose
     * @var string
     * @Assert\Length(
     *      min = "15",
     *      max = "15000",
     *      minMessage = "Votre biographie doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre biographie ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="biography", type="text", nullable=true)
     */
    private $biography;

    /**
     * @var string
     *
     * @ORM\Column(name="roles", type="text", nullable=true)
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="recompenses", type="text", nullable=true)
     */
    private $recompenses;

    /**
     * @var \DateTime
     * @Expose
     * @ORM\Column(name="date_deleted", type="datetime", nullable=true)
     */
    private $dateDeleted;

    /**
     * @var \DateTime
     * @Expose
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Movies", inversedBy="actors")
     * @ORM\JoinTable(name="actors_movies",
     *   joinColumns={
     *     @ORM\JoinColumn(name="actors_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="movies_id", referencedColumnName="id")
     *   }
     * )
     */
    private $movies;


    /**
     * @Expose
     * @ORM\Column(name="image", type="string", length=250, nullable=true)
     */
    private $image;

    /**
     * @Assert\Image(
     *     minWidth = 200,
     *     minHeight  = 100,
     *     maxWidth = 3000,
     *     maxHeight = 3000,
     *     maxSize = "6000k",
     *     mimeTypes = {"image/jpg","image/jpeg", "image/png", "image/gif", "image/bmp"},
     *     mimeTypesMessage = "Image au format non supporté",
     *    maxWidthMessage = "Image trop grande en largeur {{ width }}px. Le maximum en largeur est de {{ max_width }}px" ,
     *    minWidthMessage = "Image trop petite en largeur {{ width }}px. Le minimum en largeur est de {{ min_width }}px" ,
     *    minHeightMessage = "Image trop petite en hauteur {{ height }}px. Le mimum en hauteur est de {{ min_height }}px" ,
     *    maxHeightMessage = "Image trop grande en hauteur  {{ height }}px. Le maximum en hauteur est de {{ max_height }}px"
     * )
     */
    public $file;

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
     * @return Actors
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
     * @return Actors
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


    public function getFullname(){

        return ucfirst($this->firstname)."_".ucfirst($this->lastname);
    }
    /**
     * Set dob
     *
     * @param \DateTime $dob
     * @return Actors
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime 
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Actors
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
     * Set nationality
     *
     * @param string $nationality
     * @return Actors
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Get nationality
     *
     * @return string 
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Set biography
     *
     * @param string $biography
     * @return Actors
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
     * Set roles
     *
     * @param string $roles
     * @return Actors
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return string 
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set recompenses
     *
     * @param string $recompenses
     * @return Actors
     */
    public function setRecompenses($recompenses)
    {
        $this->recompenses = $recompenses;

        return $this;
    }

    /**
     * Get recompenses
     *
     * @return string 
     */
    public function getRecompenses()
    {
        return $this->recompenses;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Actors
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
     * Set dateDeleted
     *
     * @param \DateTime $dateDeleted
     * @return Actors
     */
    public function setDateDeleted($dateDeleted)
    {
        $this->dateDeleted = $dateDeleted;

        return $this;
    }

    /**
     * Get dateDeleted
     *
     * @return \DateTime 
     */
    public function getDateDeleted()
    {
        return $this->dateCreated;
    }
    /**
     * Add movies
     *
     * @param \Cinhetic\PublicBundle\Entity\Movies $movies
     * @return Actors
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
     * Set image
     *
     * @param string $image
     * @return Movies
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }


    /**
     * Absolute Path
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return null === $this->image ? null : $this->getUploadRootDir().'/'.$this->image;
    }

    /**
     * Web path
     * @return null|string
     */
    public function getWebPath()
    {
        return null === $this->image ? null : $this->getUploadDir().'/'.$this->image;
    }

    /**
     * Upload Path
     * @return string
     */
    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * Upload dir
     * @return string
     */
    public function getUploadDir()
    {
        return 'uploads/actors';
    }


    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            $this->image = $this->file->getClientOriginalName();
        }
    }


    /**
     * Get age of user
     * @return null|string
     */
    public function getAge()
    {
        if ($dob = $this->getDob()) {
            $now = new \Datetime('now');
            $today['month'] = $now->format('m');
            $today['day'] = $now->format('d');
            $today['year'] = $now->format('Y');

            $years = $today['year'] - $dob->format('Y');

            if ($today['month'] <= $dob->format('m')) {
                if ($dob->format('m') == $today['month']) {
                    if ($dob->format('d') > $today['day'])
                        $years--;
                } else
                    $years--;
            }

            return $years;
        }

        return null;
    }


    /**
     * Upload action
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file){
            return;
        }
        $this->image = $this->file->getClientOriginalName();
        $extension = $this->file->guessExtension();

        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());
        $path_parts = pathinfo($this->getAbsolutePath());

        $imagine = new \Imagine\Gd\Imagine();
        $imagine
            ->open($this->getAbsolutePath())
            ->thumbnail(new \Imagine\Image\Box(350, 160))
            ->save(
                $this->getUploadRootDir().'/' . $path_parts['filename'] . '-thumb.' . $extension,
                array(
                    'quality' => 80
                )
            );

    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            @unlink($file);
        }
    }


}
