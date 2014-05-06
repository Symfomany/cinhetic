<?php

namespace Cinhetic\PublicBundle\Webservice\Plateform;

use Cinhetic\PublicBundle\Webservice\WebServicesInterface;


/**
 * Class TwitterClient
 * @package Cinhetic\PublicBundle\Webservice
 */
class TwitterClient extends Client implements WebServicesInterface {


    /**
     * Returns the 20 most recent mentions (tweets containing a users's @screen_name) for the authenticating user
     * @param string $username
     * @param int $limit
     * @return array|bool|float|int|mixed|string
     */
    public function getFeeds($username = "Symfomany", $limit = 10){
        $response = $this->client->get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.$username.'&count='.$limit.'')->send();

        return $response->json();
    }


    /**
     * Returns a collection of the most recent Tweets posted by the user indicated by the screen_name or user_id parameters
     * @param string $username
     * @param int $limit
     * @return array|bool|float|int|mixed|string
     */
    public function getMentions($username = "Symfomany", $limit = 10){
        $response = $this->client->get('https://api.twitter.com/1.1/statuses/mentions_timeline.json?screen_name='.$username.'&count='.$limit.'')->send();

        return $response->json();
    }


    /**
     * Returns a collection of the most recent Tweets and retweets posted by the authenticating user and the users they follow
     * @param string $username
     * @param int $limit
     * @return array|bool|float|int|mixed|string
     */
    public function getHome($username = "Symfomany", $limit = 10){
        $response = $this->client->get('https://api.twitter.com/1.1/statuses/home_timeline.json?screen_name='.$username.'&count='.$limit.'')->send();

        return $response->json();
    }

    /**
     * Returns the most recent tweets authored by the authenticating user that have been retweeted by others.
     * @param string $username
     * @param int $limit
     * @return array|bool|float|int|mixed|string
     */
    public function getRetweets($username = "Symfomany", $limit = 10){
        $response = $this->client->get('https://api.twitter.com/1.1/statuses/retweets_of_me.json?screen_name='.$username.'&count='.$limit.'')->send();

        return $response->json();
    }

    /**
     * Returns a collection of relevant Tweets matching a specified query
     * @param string $query
     * @param int $limit
     * @return array|bool|float|int|string
     */
    public function getSearch($query = "Symfony", $limit = 10){
        $response = $this->client->get('https://api.twitter.com/1.1/search/tweets.json?q='.$query.'&count='.$limit.'')->send();

        return $response->json();
    }

    /**
     * Get Friends
     * @param string $username
     * @param int $limit
     * @return array|bool|float|int|string
     */
    public function getFriends($username = "Symfomany", $limit = 50){
        $response = $this->client->get('https://api.twitter.com/1.1/friends/ids.json?stringify_ids=true&screen_name='.$username.'&count='.$limit.'')->send();

        return $response->json();
    }


    /**
     * Get Followers
     * @param string $username
     * @param int $limit
     * @return array|bool|float|int|string
     */
    public function getFollowers($username = "Symfomany", $limit = 50){
        $response = $this->client->get('https://api.twitter.com/1.1/followers/list.json?&screen_name='.$username.'&count='.$limit.'')->send();

        return $response->json();
    }


    /**
     * Get Favorites
     * @param string $username
     * @param int $limit
     * @return array|bool|float|int|string
     */
    public function getFavorites($username = "Symfomany", $limit = 50){
        $response = $this->client->get('https://api.twitter.com/1.1/favorites/list.json?&screen_name='.$username.'&count='.$limit.'')->send();

        return $response->json();
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

    /**
     * @param array $cache
     * @return mixed
     */
    public function setCache($cache = array())
    {
        // TODO: Implement setCache() method.
    }

}
