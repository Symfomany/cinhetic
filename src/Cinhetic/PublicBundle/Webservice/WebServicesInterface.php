<?php

namespace Cinhetic\PublicBundle\Webservice;

interface WebServicesInterface{


/**
 * Get All Feeds
 * @return mixed
 */
public function getFeeds();


/**
 * Get Cached
 * @return mixed
 */
public function getCache();


/**
 * @param array $cache
 * @return mixed
 */
public function setCache($cache = array());


/**
 * Refresh Cache
 * @return mixed
 */
public function refreshCache();


/**
 * Build an url
 * @param null $url
 * @return mixed
 */
public function buildUrl($url = null);


/**
 * Set Consumer Key
 * @return mixed
 */
public function setConsumerKey();


/**
 * Get Consumer Key
 * @return mixed
 */
public function getConsumerKey();




}
