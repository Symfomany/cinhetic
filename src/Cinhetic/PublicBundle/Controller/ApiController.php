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
        $client = $this->get('guzzle.client');

        $req = $client->get('http://api.allocine.fr/rest/v3/movielist?partner=yW5kcm9pZC12M3M&count=25&filter=comingsoon&page=1&order=toprank&format=json');

        $response = $req->send();
        $movies = json_decode($response->getBody(), true);

        return $this->render('CinheticPublicBundle:Api:index.html.twig', array(
            'movies' => $movies["feed"]['movie'],
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

            return $this->render('CinheticPublicBundle:Api:show.html.twig', array(
                'entity' => $movie,
            ));
        }



    /**
     * All cinemas using API Allocine
     */
    public function cinemasAction()
        {
            $client = $this->get('guzzle.client');

            $req = $client->get('http://api.allocine.fr/rest/v3/showtimelist?code=61282&partner=yW5kcm9pZC12M3M');
            $response = $req->send();
            $status = $response->getStatusCode();
            $cinemas = json_decode($response->getBody(), true);
            exit(var_dump($response->getBody()));

            return $this->render('CinheticPublicBundle:Api:cinemas.html.twig', array(
                'movies' => $cinemas["feed"]['movie'],
            ));
        }


}
