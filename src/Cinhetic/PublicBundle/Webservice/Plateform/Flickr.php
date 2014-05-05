<?php

namespace Cinhetic\PublicBundle\Webservice\Plateform;
use Cinhetic\PublicBundle\Webservice\WebServicesInterface;


/**
 * Class Flickr
 * @package Cinhetic\PublicBundle\Webservice
 */
class Flickr extends AbstractPlateform implements WebServicesInterface {

    /**
     * Constructor
     */
    public function __construct(){

    }


    /**
     * @param string $username
     * @param int $limit
     * @return mixed|string
     */
    public function getFeeds($username = "Symfomany", $limit = 10){


//        $consumerKey = $this->consumerKey;
//        $consumerSecret = $this->consumerSecret;
//        $consumerSecret = $this->consumerSecret;
//
//        $requestTokenUrl = "https://www.flickr.com/services/oauth/request_token";
//        $oauthTimestamp = time();
//        $nonce = md5(mt_rand());
//        $oauthSignatureMethod = "HMAC-SHA1";
//        $oauthVersion = "1.0";
//
//        $sigBase = "GET&" . rawurlencode($requestTokenUrl) . "&"
//            . rawurlencode("oauth_consumer_key=" . rawurlencode($consumerKey)
//                . "&oauth_nonce=" . rawurlencode($nonce)
//                . "&oauth_signature_method=" . rawurlencode($oauthSignatureMethod)
//                . "&oauth_timestamp=" . $oauthTimestamp
//                . "&oauth_version=" . $oauthVersion);
//
//        $sigKey = $consumerSecret . "&";
//        $oauthSig = base64_encode(hash_hmac("sha1", $sigBase, $sigKey, true));
//
//        $requestUrl = $requestTokenUrl . "?"
//            . "oauth_consumer_key=" . rawurlencode($consumerKey)
//            . "&oauth_nonce=" . rawurlencode($nonce)
//            . "&oauth_signature_method=" . rawurlencode($oauthSignatureMethod)
//            . "&oauth_timestamp=" . rawurlencode($oauthTimestamp)
//            . "&oauth_version=" . rawurlencode($oauthVersion)
//            . "&oauth_signature=" . rawurlencode($oauthSig);
//
//        $response = file_get_contents($requestUrl);
//
//
//        $search = 'http://flickr.com/services/rest/?method=flickr.photos.search&api_key=' . $this->consumerKey . '&text=' . urlencode("Symfony") . '&per_page=50&format=php_serial';
//        $result = file_get_contents($search);
//        $result = unserialize($result);
//
//
//        $response = $this->client->get('http://www.flickr.com/services/oauth/request_token?oauth_nonce=fabpot')->send();
//        return $response->json();

//        $oauth = new OauthPlugin(array(
//            'consumer_key'    => $this->consumerKey,
//            'consumer_secret' => $this->consumerSecret,
//        ));
//        $this->client->addSubscriber($oauth);
//
//        $response = $this->client->get('http://www.flickr.com/services/oauth/request_token?oauth_nonce=fabpot')->send();
//
//        return $response->json();
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
        // TODO: Implement getConsumerKey() method.
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
