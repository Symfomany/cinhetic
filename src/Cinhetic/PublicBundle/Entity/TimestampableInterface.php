<?php

namespace Cinhetic\PublicBundle\Entity;

/**
 * Interface TimestampableInterface
 * @package Cinhetic\PublicBundle\Entity
 */
interface TimestampableInterface{

    /*
    * Set dateUpdated
    * @param \DateTime $dateUpdated
    * @return Movies
    */
    public function setDateUpdated(\DateTime $dateUpdated);


    /**
     * Get dateUpdated
     * @return \DateTime
     */
    public function getDateUpdated();

}