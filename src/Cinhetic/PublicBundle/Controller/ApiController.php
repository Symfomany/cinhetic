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
     * Lists all Movies using API Curl
     */
    public function indexAction()
    {
        $client = $this->get('guzzle.client');

        $req = $client->get('http://api.allocine.fr/rest/v3/movielist?partner=yW5kcm9pZC12M3M&count=25&filter=comingsoon&page=1&order=toprank&format=json');
        // You must send a request in order for the transfer to occur
        $response = $req->send();
//        echo $response->getBody();

        $movies = json_decode($response->getBody(), true);

//        var_dump($movies["feed"]['movie']);             // Outputs the JSON decoded data

//        exit();

        /*
         * Using Third Library AlloHelper for Api Allocine
        // Créer l'objet
        $helper = new \AlloHelper;
        $code = 27061;
        $profile = 'small';


            // Envoi de la requête
//            $movie = $helper->movie( $code, $profile );
            $movies = $helper->movielist();

            // Afficher le titre
           // echo "Titre du film: ", $movie->title, PHP_EOL;

            // Afficher toutes les données
            print_r($movies);
            exit();

        */
        return $this->render('CinheticPublicBundle:Api:index.html.twig', array(
            'movies' => $movies["feed"]['movie'],
        ));
    }


}
