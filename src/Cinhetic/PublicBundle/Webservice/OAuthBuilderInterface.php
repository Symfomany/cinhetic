<?php

namespace Cinhetic\PublicBundle\Webservice;

/**
 * OAuth Interface
 * Interface OAuthInterface
 * @package Cinhetic\PublicBundle\Webservice
 */
interface OAuthBuilderInterface{


/**
 * Get Oauth
 * @return mixed
 */
public function getOAuth();


/**
 * Set OAuth
 * @param $consumerKey
 * @param $consumerSecret
 * @return mixed
 */
public function setOAuth($consumerKey, $consumerSecret);


/**
 * Setting the name of app
 * @param $name
 * @return mixed
 */
public function setAppName($name);


/**
 * Set redirect an url
 * @param $url
 * @return mixed
 */
public function setRedirectUrl($url);


/**
 * Get Access Token
 * @return mixed
 */
public function getAccessToken();


/**
 * Set access token
 * @param $token
 * @return mixed
 */
public function setAccessToken($token);


}
