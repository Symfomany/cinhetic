<?php

namespace Cinhetic\PublicBundle\Controller;

use Cinhetic\PublicBundle\Entity\Medias;
use Cinhetic\PublicBundle\Form\SearchType;
use Doctrine\Common\Collections\ArrayCollection;
use Essence\Essence;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Cinhetic\PublicBundle\Entity\Movies;
use Cinhetic\PublicBundle\Form\MoviesType;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class FeedsController
 * @package Cinhetic\PublicBundle\Controller
 */
class FeedsController extends AbstractController
{


    /**
     * @var
     */
    protected $reader;


    /**
     * Constructor
     */
    public function __construct(){
        $this->reader = $this->get('eko_feed.feed.reader');
    }


    public function notmissingAction(){
        $reader = $this->get('eko_feed.feed.reader');
        $feeds = $reader->load('http://rss.allocine.fr/ac/bandesannonces/anepasmanquer?format=xml')->get();

        return $this->render('CinheticPublicBundle:Feeds:notmissing.html.twig', array(
            '$feeds' => $feeds
        ));
    }


    public function weekAction(){
        $reader = $this->get('eko_feed.feed.reader');
        $feeds = $reader->load('http://rss.allocine.fr/ac/cine/cettesemaine?format=xml')->get();

        return $this->render('CinheticPublicBundle:Feeds:notmissing.html.twig', array(
            '$feeds' => $feeds
        ));
    }


    public function topAction(){
        $reader = $this->get('eko_feed.feed.reader');
        $feeds = $reader->load('http://rss.allocine.fr/ac/cine/topfilms?format=xml')->get();

        return $this->render('CinheticPublicBundle:Feeds:notmissing.html.twig', array(
            '$feeds' => $feeds
        ));
    }


    public function posterAction(){
        $reader = $this->get('eko_feed.feed.reader');
        $feeds = $reader->load('http://rss.allocine.fr/ac/bandesannonces/alaffiche?format=xml')->get();

        return $this->render('CinheticPublicBundle:Feeds:notmissing.html.twig', array(
            '$feeds' => $feeds
        ));
    }


    public function shortlyAction(){
        $reader = $this->get('eko_feed.feed.reader');
        $feeds = $reader->load('http://rss.allocine.fr/ac/bandesannonces/prochainement?format=xml')->get();

        return $this->render('CinheticPublicBundle:Feeds:notmissing.html.twig', array(
            '$feeds' => $feeds
        ));
    }

    public function newsAction(){
        $reader = $this->get('eko_feed.feed.reader');
        $feeds = $reader->load('http://rss.allocine.fr/ac/actualites/cine?format=xml')->get();

        return $this->render('CinheticPublicBundle:Feeds:notmissing.html.twig', array(
            '$feeds' => $feeds
        ));
    }



}
