<?php

namespace Cinhetic\PublicBundle\Webservice;

use Cinhetic\PublicBundle\Webservice\Plateform\Flickr;
use Cinhetic\PublicBundle\Webservice\Plateform\Thumblr;
use Cinhetic\PublicBundle\Webservice\Plateform\Twitter;
use Cinhetic\PublicBundle\Webservice\Plateform\Youtube;
use Elastica\Exception\NotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Guzzle\Service\Client;

/**
 * To load each webservice by type with params
 * Class WebServicesFactory
 * @package Cinhetic\PublicBundle\Webservice
 */
class WebServicesFactory implements OAuthInterface {

    /**
     * All Allow services
     * @var array
     */
    protected static $allowservices  = array("twitter","flickr");

    /**
     * The Guzzle Client
     * @var \Guzzle\Service\Client
     */
    protected $client;

    /**
     * Consumer Key
     * @var
     */
    protected $consumerKey;

    /**
     * Consumer Secret
     * @var
     */
    protected $consumerSecret;

    /**
     * OAuth object
     * @var
     */
    protected $oAuth;

    /**
     * Name of Apps
     * @var
     */
    protected $name;

    /**
     * URL of redirection after authentificate
     * @var
     */
    protected $redirectUrl;

    /**
     * Webservice object
     * @var
     */
    protected static $webservice;

    /**
     * Additional datas
     * @var
     */
    protected $datas;


    /**
     * Constructor
     * @param Client $client
     * @param $consumer_key
     * @param $consumer_secret
     */
    public function __construct(Client $client, $consumer_key, $consumer_secret){
        $this->client = $client;
        $this->consumerKey = $consumer_key;
        $this->consumerSecret = $consumer_secret;
    }


    /**
     * Build the webservice
     * @param $type
     * @param array $params
     * @return Flickr|Thumblr|Twitter|Youtube
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public static function build($type, $params = array()){

        if (!in_array(strtolower($type), self::$allowservices)){
            throw new InvalidOptionsException('Webservice innexistant');
        }

        switch (strtolower($type)){
            case 'twitter':
                self::$webservice = new Twitter($params);
                break;
            case 'flickr':
                self::$webservice = new Flickr($params);
                break;
            case 'youtube':
                self::$webservice = new Youtube($params);
                break;
            case 'thumblr':
                self::$webservice = new Thumblr($params);
                break;
            default:
                throw new NotFoundHttpException('Web Service not implemented.');
        }

        return self::$webservice;
    }



    /**
     * Get OAuth
     * @return OauthPlugin
     */
    public function getOAuth(){
        return new OauthPlugin(array(
            'consumer_key'    => $this->consumerKey,
            'consumer_secret' => $this->consumerSecret,
        ));
    }

    /**
     * Settng Oauth
     * @param $consumerKey
     * @param $consumerSecret
     * @return OauthPlugin
     */
    public function setOAuth($consumerKey, $consumerSecret){
        return new OauthPlugin(array(
            'consumer_key'    => $consumerKey,
            'consumer_secret' => $consumerSecret,
        ));
    }

    /**
     * Setting the name of app
     * @param $name
     * @return mixed
     */
    public function setAppName($name)
    {
        $this->name = $name;
    }

    /**
     * Set redirect an url
     * @param $url
     * @return mixed
     */
    public function setRedirectUrl($url)
    {
        $this->redirectUrl = $url;
    }


    /**
     * @param array $allowservices
     */
    public static function setAllowservices($allowservices)
    {
        self::$allowservices = $allowservices;
    }

    /**
     * @return array
     */
    public static function getAllowservices()
    {
        return self::$allowservices;
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
     * @param mixed $consumerKey
     */
    public function setConsumerKey($consumerKey)
    {
        $this->consumerKey = $consumerKey;
    }

    /**
     * @return mixed
     */
    public function getConsumerKey()
    {
        return $this->consumerKey;
    }

    /**
     * @param mixed $consumerSecret
     */
    public function setConsumerSecret($consumerSecret)
    {
        $this->consumerSecret = $consumerSecret;
    }

    /**
     * @return mixed
     */
    public function getConsumerSecret()
    {
        return $this->consumerSecret;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
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

    /**
     * Get Access Token
     * @return mixed
     */
    public function getAccessToken()
    {
        // TODO: Implement getAccessToken() method.
    }

    /**
     * Set access token
     * @param $token
     * @return mixed
     */
    public function setAccessToken($token)
    {
        // TODO: Implement setAccessToken() method.
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

}
