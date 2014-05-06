<?php

namespace Cinhetic\PublicBundle\Webservice\Plateform;
use Cinhetic\PublicBundle\Webservice\WebServicesInterface;


/**
 * Class FlickrClient
 * @package Cinhetic\PublicBundle\Webservice
 */
class FlickrClient extends Client implements WebServicesInterface {



    /**
     * @param string $username
     * @param int $limit
     * @return mixed|string
     */
    public function getFeeds($username = "Symfony", $limit = 10){

        $search = $this->client->get("http://flickr.com/services/rest/?method=flickr.photos.search&api_key=" . $this->customerkey . "&text=" . urlencode('Symfony') . "&per_page=50&format=php_serial")->send();

        return $search;
    }


    /**
     * @param null $url
     * @return mixed|null|string
     */
    public function buildUrl($url = null) {
        $sizes = array(
            "square" => "_s",
            "thumbnail" => "_t",
            "small" => "_m",
            "medium" => "",
            "medium_640" => "_z",
            "large" => "_b",
            "original" => "_o"
        );

        $size = "medium";


        if ($size == "original") {
            $url = "http://farm" . $url['farm'] . ".static.flickr.com/" . $url['server'] . "/" . $url['id'] . "_" . $url['originalsecret'] . "_o" . "." . $url['originalformat'];
        } else {
            $url = "http://farm" . $url['farm'] . ".static.flickr.com/" . $url['server'] . "/" . $url['id'] . "_" . $url['secret'] . $sizes[$size] . ".jpg";
        }
        return $url;
    }

    /**
     * Get Cache
     * @return mixed|void
     */
    function getCache()
    {

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
    }

    /**
     * @param array $cache
     * @return mixed
     */
    public function setCache($cache = array())
    {
        // TODO: Implement setCache() method.
    }
}
