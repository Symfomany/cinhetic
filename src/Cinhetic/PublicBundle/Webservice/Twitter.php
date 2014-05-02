<?php

namespace Cinhetic\PublicBundle\Webservice;

use Guzzle\Service\Client;

class Twitter{

    protected $client;

    public function __construct(Client $client ){

        $this->client = $client;

    }


    public function getFeeds(){

        return array();
    }

}
