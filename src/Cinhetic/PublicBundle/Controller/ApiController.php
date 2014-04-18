<?php

namespace Cinhetic\PublicBundle\Controller;

use Cinhetic\PublicBundle\Form\SearchType;
use Guzzle\Http\Client;
use JsonSchema\Uri\Retrievers\Curl;
use Misd\GuzzleBundle\MisdGuzzleBundle;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cinhetic\PublicBundle\Entity\Movies;
use Cinhetic\PublicBundle\Form\MoviesType;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Api controller.
 * Using Guzzle HTTP Frameworks
 *
 */
class ApiController extends Controller
{

    /**
     * Lists all Movies using API Allocine
     */
    public function indexAction()
    {
        $helper = new \AlloHelper;
        $movies = $helper->movielist();

//        exit(var_dump($movies['movie']));
        return $this->render('CinheticPublicBundle:Api:index.html.twig', array(
            'movies' => $movies['movie'],
        ));
    }


    /**
     * Show a movie using API Allocine
     */
    public function showAction($code = null)
        {
           // Créer l'objet
           $helper = new \AlloHelper;
           $profile = 'long';

           // Envoi de la requête
            $movie = $helper->movie($code, $profile );
//            exit(var_dump($movie));

            return $this->render('CinheticPublicBundle:Api:show.html.twig', array(
                'entity' => $movie,
            ));
        }



    /**
     * Show a movie using API Allocine
     */
    public function actorAction($code = null)
        {
           // Créer l'objet
           $helper = new \AlloHelper;
           $profile = 'long';

           // Envoi de la requête
            $actor = $helper->person($code, $profile);
//            exit(var_dump($actor));

            return $this->render('CinheticPublicBundle:Api:actor.html.twig', array(
                'entity' => $actor,
                'movies' => $actor['participation']->getArray()
            ));
        }



    /**
     * Show a movie using API Allocine
     */
    public function filmographyAction($code = null)
        {
           // Créer l'objet
           $helper = new \AlloHelper;
           $profile = 'long';

           // Envoi de la requête
            $filmography = $helper->filmography($code, $profile);

//            exit(var_dump($filmography['participation'][2]['movie']['originalTitle']));

            return $this->render('CinheticPublicBundle:Api:filmography.html.twig', array(
                'entity' => $filmography,
                'movies' => $filmography['participation']->getArray()
            ));
        }



    /**
     * All cinemas using API Allocine
     */
    public function cinemasAction($zipcode = "75000")
        {

            $helper = new \AlloHelper;
            $cinemas = $helper->showtimesByZip($zipcode);
//            exit(var_dump($cinemas));

            return $this->render('CinheticPublicBundle:Api:cinemas.html.twig', array(
                'cinemas' => $cinemas['theaterShowtimes']->getArray(),
            ));
        }



    /**
     * All cinemas using API Allocine
     */
    public function cinemasyPositionAction($long = null, $lat = null)
        {

            $helper = new \AlloHelper;
            $profile = 'long';
            $codes = array();
            // Envoi de la requête
            $actor = $helper->showtimesByPosition(12.5655,12.3532, $profile);

            return $this->render('CinheticPublicBundle:Api:actor.html.twig', array(
                'entity' => $actor,
            ));

           /* $client = $this->get('guzzle.client');

            $req = $client->get('http://api.allocine.fr/rest/v3/showtimelist?code=61282&partner=yW5kcm9pZC12M3M');
            $response = $req->send();
            $status = $response->getStatusCode();
            $cinemas = json_decode($response->getBody(), true);
            exit(var_dump($response->getBody()));
            */
            return $this->render('CinheticPublicBundle:Api:cinemas.html.twig', array(
                'movies' => $cinemas["feed"]['movie'],
            ));
        }



    /**
     * All cinemas using API Allocine
     */
    public function cinemasyZipAction($zipcode=  null)
        {

            $helper = new \AlloHelper;
            $profile = 'long';
            $codes = array();
            // Envoi de la requête
            $actor = $helper->showtimesByZip(75002, $profile);

            return $this->render('CinheticPublicBundle:Api:actor.html.twig', array(
                'entity' => $actor,
            ));

           /* $client = $this->get('guzzle.client');

            $req = $client->get('http://api.allocine.fr/rest/v3/showtimelist?code=61282&partner=yW5kcm9pZC12M3M');
            $response = $req->send();
            $status = $response->getStatusCode();
            $cinemas = json_decode($response->getBody(), true);
            exit(var_dump($response->getBody()));
            */
            return $this->render('CinheticPublicBundle:Api:cinemas.html.twig', array(
                'movies' => $cinemas["feed"]['movie'],
            ));
        }



    /**
     * All cinemas using API Allocine
     */
    public function searchAction($word =  null)
        {

            $helper = new \AlloHelper;
            $profile = 'long';
            $codes = array();
            // Envoi de la requête
            $actor = $helper->showtimesByZip(75002, $profile);

            return $this->render('CinheticPublicBundle:Api:actor.html.twig', array(
                'entity' => $actor,
            ));

           /* $client = $this->get('guzzle.client');

            $req = $client->get('http://api.allocine.fr/rest/v3/showtimelist?code=61282&partner=yW5kcm9pZC12M3M');
            $response = $req->send();
            $status = $response->getStatusCode();
            $cinemas = json_decode($response->getBody(), true);
            exit(var_dump($response->getBody()));
            */
            return $this->render('CinheticPublicBundle:Api:cinemas.html.twig', array(
                'movies' => $cinemas["feed"]['movie'],
            ));
        }


}
