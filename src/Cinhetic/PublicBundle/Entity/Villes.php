<?php

namespace Cinhetic\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Villes
 *
 * @ORM\Table(name="villes")
 * @ORM\Entity(repositoryClass="Cinhetic\PublicBundle\Repository\VillesRepository")
 */
class Villes
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
     *
     * @ORM\Column(name="departement", type="string", length=2, nullable=true)
     */
    private $departement;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_ville", type="string", length=255, nullable=true)
     */
    private $nomVille;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_ville_maj", type="string", length=255, nullable=true)
     */
    private $nomVilleMaj;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_ville_url", type="string", length=255, nullable=true)
     */
    private $nomVilleUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", length=5, nullable=true)
     */
    private $codePostal;

    /**
     * @var integer
     *
     * @ORM\Column(name="code_insee", type="integer", nullable=true)
     */
    private $codeInsee;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", nullable=true)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", nullable=true)
     */
    private $longitude;

    /**
     * @var float
     *
     * @ORM\Column(name="latRad", type="float", nullable=true)
     */
    private $latrad;

    /**
     * @var float
     *
     * @ORM\Column(name="lonRad", type="float", nullable=true)
     */
    private $lonrad;



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
     * Set departement
     *
     * @param string $departement
     * @return Villes
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;
    
        return $this;
    }

    /**
     * Get departement
     *
     * @return string 
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Set nomVille
     *
     * @param string $nomVille
     * @return Villes
     */
    public function setNomVille($nomVille)
    {
        $this->nomVille = $nomVille;
    
        return $this;
    }

    /**
     * Get nomVille
     *
     * @return string 
     */
    public function getNomVille()
    {
        return $this->nomVille;
    }

    /**
     * Set nomVilleMaj
     *
     * @param string $nomVilleMaj
     * @return Villes
     */
    public function setNomVilleMaj($nomVilleMaj)
    {
        $this->nomVilleMaj = $nomVilleMaj;
    
        return $this;
    }

    /**
     * Get nomVilleMaj
     *
     * @return string 
     */
    public function getNomVilleMaj()
    {
        return $this->nomVilleMaj;
    }

    /**
     * Set nomVilleUrl
     *
     * @param string $nomVilleUrl
     * @return Villes
     */
    public function setNomVilleUrl($nomVilleUrl)
    {
        $this->nomVilleUrl = $nomVilleUrl;
    
        return $this;
    }

    /**
     * Get nomVilleUrl
     *
     * @return string 
     */
    public function getNomVilleUrl()
    {
        return $this->nomVilleUrl;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     * @return Villes
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
    
        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string 
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set codeInsee
     *
     * @param integer $codeInsee
     * @return Villes
     */
    public function setCodeInsee($codeInsee)
    {
        $this->codeInsee = $codeInsee;
    
        return $this;
    }

    /**
     * Get codeInsee
     *
     * @return integer 
     */
    public function getCodeInsee()
    {
        return $this->codeInsee;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return Villes
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
     * Set longitude
     *
     * @param float $longitude
     * @return Villes
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
     * Set latrad
     *
     * @param float $latrad
     * @return Villes
     */
    public function setLatrad($latrad)
    {
        $this->latrad = $latrad;
    
        return $this;
    }

    /**
     * Get latrad
     *
     * @return float 
     */
    public function getLatrad()
    {
        return $this->latrad;
    }

    /**
     * Set lonrad
     *
     * @param float $lonrad
     * @return Villes
     */
    public function setLonrad($lonrad)
    {
        $this->lonrad = $lonrad;
    
        return $this;
    }

    /**
     * Get lonrad
     *
     * @return float 
     */
    public function getLonrad()
    {
        return $this->lonrad;
    }


    /**
     * @return string
     */
    public function __toString(){
        return $this->getNomVille();
    }
}