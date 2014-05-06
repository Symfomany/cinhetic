<?php

namespace Cinhetic\PublicBundle\Webservice;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Guzzle\Service\Client;

/**
 * To load each webservice by type with params
 * Class WebServicesFactory
 * @package Cinhetic\PublicBundle\Webservice
 */
class WebServicesFactory {


    /**
     * The Guzzle Client
     * @var \Guzzle\Service\Client
     */
    protected $client;

    /**
     * Allowed services
     * @var array
     */
    protected static $allowedServices = array('twitter','youtube','thumblr','flickr');

    /**
     * Webservice object
     * @var
     */
    protected $webservice;

    /**
     * Additional datas
     * @var
     */
    protected $datas;


    /**
     * Constructor with Guzzle Client
     * @param Client $client
     */
    public function __construct(Client $client){
        $this->client = $client;
    }



    /**
     * Build the webservice
     * @param $type
     * @param array $params
     * @return Flickr|Thumblr|Twitter|Youtube
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function build($type, $params = array()){

            if(in_array(strtolower($type), self::$allowedServices)){
                $class = "Cinhetic\\PublicBundle\\Webservice\\Plateform\\".ucfirst($type)."Client";
                $this->webservice = new $class($this->getClient(), $params);
            }else{
                throw new NotFoundHttpException('Web Service not implemented.');
            }

        return $this->webservice;
    }

    /**
     * Setting additional datas in $datas Array
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->datas[$name] = $value;
    }

    /**
     * Existing attributes in datas
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->datas[$name]);
    }

    /**
     * Get additional datas
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->datas)) {
            return $this->datas[$name];
        }
        return null;
    }


    /**
     * To string and object
     * @return string
     */
    public function __toString(){
        return ucfirst(get_class($this->webservice));
    }

    /**
     * @param array $allowedServices
     */
    public static function setAllowedServices($allowedServices)
    {
        self::$allowedServices = $allowedServices;
    }

    /**
     * @return array
     */
    public static function getAllowedServices()
    {
        return self::$allowedServices;
    }

    /**
     * @param \Guzzle\Service\Client $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return \Guzzle\Service\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $datas
     */
    public function setDatas($datas)
    {
        $this->datas = $datas;
    }

    /**
     * @return mixed
     */
    public function getDatas()
    {
        return $this->datas;
    }

    /**
     * @param mixed $webservice
     */
    public function setWebservice($webservice)
    {
        $this->webservice = $webservice;
    }

    /**
     * @return mixed
     */
    public function getWebservice()
    {
        return $this->webservice;
    }


}
