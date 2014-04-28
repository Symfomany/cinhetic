<?php
// src/Sdz/UserBundle/Entity/User.php

namespace Cinhetic\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Cinhetic\PublicBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var $id
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", name="extras")
     */
    protected $extras;


    /**
     * @ORM\Column(type="text", name="ville")
     */
    protected $ville;

    /**
     * @ORM\Column(type="text", name="zipcode")
     */
    protected $zipcode;

    /**
     * @ORM\Column(type="text", name="tel")
     */
    protected $tel;

    /**
     * @ORM\Column(type="text", name="ip")
     */
    protected $ip;

    /**
     * @ORM\Column(type="float", name="longitude")
     */
    protected $longitude;

    /**
     * @ORM\Column(type="float", name="latitude")
     */
    protected $latitude;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at")
     */
    protected $updatedAt;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Movies")
     * @ORM\JoinTable(name="user_favoris",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="movies_id", referencedColumnName="id")
     *   }
     * )
     */
    private $favorites;

    /**
     * @var string
     *
     * @ORM\Column(name="facebookId", type="string", length=255)
     */
    protected $facebookId;


    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->createdAt = new \Datetime('now');
        $this->updatedAt = new \Datetime('now');

        // your own logic
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
     * Set extras
     *
     * @param string $extras
     * @return User
     */
    public function setExtras($extras)
    {
        $this->extras = $extras;

        return $this;
    }

    /**
     * Get extras
     *
     * @return string
     */
    public function getExtras()
    {
        return $this->extras;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return User
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
     * Set zipcode
     *
     * @param string $zipcode
     * @return User
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return User
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return User
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return User
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return User
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }



    /**
     * Add favorites
     *
     * @param \Cinhetic\PublicBundle\Entity\Movies $favorites
     * @return User
     */
    public function addFavorite(\Cinhetic\PublicBundle\Entity\Movies $favorites)
    {
        $this->favorites[] = $favorites;

        return $this;
    }

    /**
     * Remove favorites
     *
     * @param \Cinhetic\PublicBundle\Entity\Movies $favorites
     */
    public function removeFavorite(\Cinhetic\PublicBundle\Entity\Movies $favorites)
    {
        $this->favorites->removeElement($favorites);
    }

    /**
     * Get favorites
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFavorites()
    {
        return $this->favorites;
    }


    /**
     * Get Department of user
     * @return string
     */
    public function getDepartement(){
        return substr($this->zipcode,0,2);
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
     * @return string
     */
    public function __toString(){
        return $this->email." ".$this->username;
    }


    /**
     * Serialize an user object
     * @return string
     */
    public function serialize()
    {
        return serialize(array($this->facebookId, parent::serialize()));
    }

    /**
     * Deserialize an user object
     * @param string $data
     */
    public function unserialize($data)
    {
        list($this->facebookId, $parentData) = unserialize($data);
        parent::unserialize($parentData);
    }


    /**
     * @param string $facebookId
     * @return void
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
        $this->setUsername($facebookId);
    }

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param Array
     */
    public function setFBData($fbdata)
    {
        if (isset($fbdata['id'])) {
            $this->setFacebookId($fbdata['id']);
            $this->addRole('ROLE_FACEBOOK');
        }
        if (isset($fbdata['first_name'])) {
            $this->setFirstname($fbdata['first_name']);
        }
        if (isset($fbdata['last_name'])) {
            $this->setLastname($fbdata['last_name']);
        }
        if (isset($fbdata['email'])) {
            $this->setEmail($fbdata['email']);
        }
    }
}
