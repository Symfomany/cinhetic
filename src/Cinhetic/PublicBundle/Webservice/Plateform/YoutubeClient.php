<?php

namespace Cinhetic\PublicBundle\Webservice\Plateform;

use Guzzle\Plugin\Oauth\OauthPlugin;
use Guzzle\Service\Client;

/**
 * Class YoutubeClient
 * @package Cinhetic\PublicBundle\Webservice
 */
class YoutubeClient extends AbstractPlateform implements WebserviceInterface {
    /**
     * Get All Feeds
     * @return mixed
     */
    public function getFeeds()
    {
        // TODO: Implement getFeeds() method.
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
     * @param array $cache
     * @return mixed
     */
    public function setCache($cache = array())
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
     * Build an url
     * @param null $url
     * @return mixed
     */
    public function buildUrl($url = null)
    {
        // TODO: Implement buildUrl() method.
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

}
