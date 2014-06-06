<?php

namespace Cinhetic\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;


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
     * @Assert\Choice(choices = {"1", "2"}, message = "Choisissez une nature valide.")
     * @ORM\Column(name="nature", type="integer", nullable=true)
     */
    private $nature;

    /**
     * @var string
     * @Assert\Url(message="La vidéo doit être une url")
     * @ORM\Column(name="picture", type="text", nullable=true)
     */
    private $picture;

    /**
     * @var string
     * @Assert\Url(message="La vidéo doit être une url")
     * @ORM\Column(name="video", type="text", nullable=true)
     */
    private $video;

    /**
     * @var \movies
     * @ORM\ManyToOne(targetEntity="Movies", inversedBy="medias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="movies_id", referencedColumnName="id")
     * })
     */
    private $movies;


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
        $this->dateCreated = new \Datetime('now');
        $this->movies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->nature="1";
    }



    /**
     * @return int
     */
    public function __toString(){
        return $this->video;
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
     * @param \Cinhetic\PublicBundle\Entity\Movies $movies
     * @return Medias
     */
    public function setMovies(\Cinhetic\PublicBundle\Entity\Movies $movies = null)
    {
        $this->movies = $movies;
        $this->nature = 2;

        return $this;
    }


    /**
     * Add movies
     *
     * @param \Cinhetic\PublicBundle\Entity\Movies $movies
     * @return Medias
     */
    public function addMovie(\Cinhetic\PublicBundle\Entity\Movies $movies)
    {
        $this->movies[] = $movies;
        $this->nature = 2;
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
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            $this->picture = $this->file->getClientOriginalName();
        }
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
        $this->picture = $this->file->getClientOriginalName();
        $extension = $this->file->guessExtension();
        $this->nature = 1;
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

    /**
     * Set file
     *
     * @param string $file
     * @return Movies
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }


    /**
     * Absolute Path
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return null === $this->picture ? null : $this->getUploadRootDir().'/'.$this->picture;
    }

    /**
     * Web path
     * @return null|string
     */
    public function getWebPath()
    {
        return null === $this->picture ? null : $this->getUploadDir().'/'.$this->picture;
    }

    /**
     * Upload Path
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * Upload dir
     * @return string
     */
    protected function getUploadDir()
    {
        return 'uploads/medias';
    }
}
