<?php

namespace Cinhetic\PublicBundle\Controller;

use Doctrine\Common\Util\Debug;
use Cinhetic\PublicBundle\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Class MainController
 * @package Cinhetic\PublicBundle\Controller
 */
class MainController extends AbstractController
{


    /**
     * @var \AlloHelper
     */
    protected $helper;

    /**
     * Constructor of APIController
     */
    public function __construct(){
        $this->helper = new \AlloHelper;
    }

    /**
     * Homepage Get Started
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        return $this->render('CinheticPublicBundle:Main:home.html.twig');
    }


    /**
     * Homepage Get Started
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function oneAction()
    {
        return $this->render('CinheticPublicBundle:Apprentissage:01.html.twig');
    }


    /**
     * Apprentissage Get Started
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function apprentissageAction()
    {
        return $this->render('CinheticPublicBundle:Apprentissage:apprentissage.html.twig');
    }

    /**
     * Main Dashboard Homepage
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
       /* $paybox = $this->get('lexik_paybox.request_handler');
        $paybox->setParameters(array(
            'PBX_CMD'          => 'CMD'.time(),
            'PBX_DEVISE'       => '978',
            'PBX_PORTEUR'      => 'test@paybox.com',
            'PBX_RETOUR'       => 'Mt:M;Ref:R;Auto:A;Erreur:E',
            'PBX_TOTAL'        => '1000',
            'PBX_TYPEPAIEMENT' => 'CARTE',
            'PBX_TYPECARTE'    => 'CB',
            'PBX_EFFECTUE'     => $this->generateUrl('lexik_paybox_return', array('status' => 'success'), true),
            'PBX_REFUSE'       => $this->generateUrl('lexik_paybox_return', array('status' => 'denied'), true),
            'PBX_ANNULE'       => $this->generateUrl('lexik_paybox_return', array('status' => 'canceled'), true),
            'PBX_RUF1'         => 'POST',
            'PBX_REPONDRE_A'   => $this->generateUrl('lexik_paybox_ipn', array('time' => time()), true),
        ));*/
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("index"));

        $em = $this->getDoctrine()->getManager();
        $commentaires = $em->getRepository('CinheticPublicBundle:Comments')->getAllComments();
        
        $seances = $em->getRepository('CinheticPublicBundle:Sessions')->getNextSessions();
        $categories = $em->getRepository('CinheticPublicBundle:Categories')->findAll();
        $tags = $em->getRepository('CinheticPublicBundle:Tags')->findAll();
              
        $movies = $em->getRepository('CinheticPublicBundle:Movies')->getCount();
        $actors = $em->getRepository('CinheticPublicBundle:Actors')->getCount();
        $directors = $em->getRepository('CinheticPublicBundle:Directors')->getCount();
        $cinemas = $em->getRepository('CinheticPublicBundle:Cinema')->getCount();

        $allocine_movies = $this->helper->movielist();

        $vues = array();
            if(isset($allocine_movies['movie']) && is_object($allocine_movies['movie'])){
            foreach($allocine_movies['movie'] as $mov){
                $vues[] = array(
                    "title" => $mov['originalTitle'],
                    "nbviews" => $mov['statistics']['userRatingCount'],
                    "nbcomments" => $mov['statistics']['commentCount'],
                );
            }
        }
        
        $stats_movies_categories = $em->getRepository('CinheticPublicBundle:Movies')->getStatsMoviesCategories();
        
        $seance = null;
        if(!empty($seances)){
            shuffle($seances);
            if(count($seances) > 1){
                $seance = array_shift(array_values($seances));
            }else{
                $seance = $seances[0];
            }
        }
        
        // Twitter feeds
        $params['consumer_key'] = $this->container->getParameter('api_twitter_id');
        $params['consumer_secret'] = $this->container->getParameter('api_twitter_secret');
        $params['oauth_access_token'] = $this->container->getParameter('api_twitter_access_token');
        $params['oauth_access_token_secret'] = $this->container->getParameter('api_twitter_access_token_secret');
        $params['callback_url'] = null;
        $webservice = $this->get('cinhetic_public.webservices')->build('Twitter', $params);
        $tweets = $webservice->getFeeds('allocine', 7);
        $infos = $webservice->getInfos('allocine');


        return $this->display('index.html.twig',  array(
            'seances' => $seances,
            'categories' => $categories,
            'tweets' => $tweets,
            'comments' => $this->paginate($commentaires,5),
            'tags' => $tags,
            'url'  => null,
            'form' => null,
            'movies' => $movies,
            'vues' => $vues,
            'infos' => $infos,
            'actors' => $actors,
            'directors' => $directors,
            'cinemas' => $cinemas,
            'stats_movies_categories' => $stats_movies_categories,
            'seance' => $seance
           // 'url'  => $paybox->getUrl(),
            //'form' => $paybox->getForm()->createView()
        ));
    }

    /**
     * Sample action of a confirmation payment page on witch the user is sent
     * after he seizes his payment informations on the Paybox's platform.
     * This action must only containts presentation logic.
     */
    public function buildPayboxAction()
    {
        $status = $this->get('request')->query->get('status');
        return $this->render(
            'CinheticPublicBundle:Main:return.html.twig',
            array(
                'status'     => $status,
            )
        );
    }

    /**
     * Sample action of a confirmation payment page on witch the user is sent
     * after he seizes his payment informations on the Paybox's platform.
     * This action must only containts presentation logic.
     */
    public function responsePayboxAction()
    {

        //messages flash se jouant qu'une seule fois
        $this->setMessage('Votre commande de votre film a bien été prise en compte');

        //redirections
        return $this->redirect($this->generateUrl('Cinhetic_public_homepage'));
    }

    /**
     * Sample action of a confirmation payment page on witch the user is sent
     * after he seizes his payment informations on the Paybox's platform.
     * This action must only containts presentation logic.
     */
    public function returnPayboxPayboxAction($time)
    {
        return $this->render(
            'CinheticPublicBundle:Main:time.html.twig',
            array(
                'time'     => $time,
            )
        );
    }

    /**
     * Search Action
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction($word = null)
    {
        $form = $this->createForm(new SearchType(), null, array(
            'action' => $this->generateUrl('Cinhetic_public_search'),
            'method' => 'POST',
        ));

        return $this->render('CinheticPublicBundle:Slots:search.html.twig',
            array('form' => $form->createView(), 'word' => $word)
        );
    }



    /**
     * Login Authentification
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        return $this->render('CinheticPublicBundle:Main:login.html.twig', array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }

    /**
     * Logout action
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logoutAction() {

        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
        return $this->redirect($this->generateUrl('fos_user_security_login'));
    }

}
