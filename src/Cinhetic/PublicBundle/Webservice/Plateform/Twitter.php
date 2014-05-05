<?php

namespace Cinhetic\PublicBundle\Webservice\Plateform;

use Guzzle\Plugin\Oauth\OauthPlugin;
use Guzzle\Service\Client;

/**
 * Class Twitter
 * @package Cinhetic\PublicBundle\Webservice
 */
class Twitter extends AbstractPlateform implements WebServicesInterface{


    /**
     * @var
     */
    protected $webservice;


    /**
     * Webservice param
     * @param WebServicesInterface $webservice
     */
    public function __construct($params = array()){
        $this->webservice = $webservice;
    }


    /**
     * @param string $username
     * @param int $limit
     * @return array|bool|float|int|mixed|string
     */
    public function getFeeds($username = "Symfomany", $limit = 10){

//        $oauth = new OauthPlugin(array(
//            'consumer_key'    => $this->consumerKey,
//            'consumer_secret' => $this->consumerSecret,
//            'token'           => $this->accessToken,
//            'token_secret'    => $this->accessTokenSecret
//        ));
//        $this->client->addSubscriber($oauth);
//
//        $response = $this->client->get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.$username.'&count='.$limit.'')->send();
//
//        return $response->json();
    }

    /**
     * Get Cached
     * @return mixed
     */
    public function getCache()
    {
        // TODO: Implement getCache() method.
    }

    /**
     * Set Cache
     * @return mixed
     */
    public function setCache()
    {
        // TODO: Implement setCache() method.
    }

    /**
     * Refresh Cache
     * @return mixed
     */
    public function refreshCache()
    {
        // TODO: Implement refreshCache() method.
    }

    /**
     * Set Consumer Key
     * @return mixed
     */
    public function setConsumerKey()
    {
        // TODO: Implement setConsumerKey() method.
    }

    /**
     * Get Consumer Key
     * @return mixed
     */
    public function getConsumerKey()
    {
        // TODO: Implement getConsumerKey() method.
    }

    /**
     * Build an url
     * @param null $url
     * @return mixed
     */
    public function buildUrl($url = null)
    {
        // TODO: Implement buildUrl() method.
    }


}
