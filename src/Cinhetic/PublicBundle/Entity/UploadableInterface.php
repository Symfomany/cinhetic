<?php

namespace Cinhetic\PublicBundle\Entity;


/**
 * Interface UploadableInterface
 * @package Cinhetic\PublicBundle\Entity
 */
interface UploadableInterface{

    /*
    * Upload action
    */
    public function upload();

    /**
     * Relative upload directory
     */
    public function getUploadDir();

    /**
     * Absolute upload directory
     */
    public function getUploadRootDir();

    /**
     * Get web Path
     */
    public function getWebPath();

    /**
     * Get absolute web path
     */
    public function getAbsolutePath();


}