<?php

namespace Cinhetic\PublicBundle\Controller;

use Doctrine\Common\Util\Debug;
use Cinhetic\PublicBundle\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;


class MainController extends Controller
{

    /**
     * Homepage Dashboard
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {

        return $this->render('CinheticPublicBundle:Main:home.html.twig');
    }

    /**
     * Main Dashboard
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        //je récupere l'Entity Manager pour jouer avec les entités
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator'); //je mets en place la pagination

        //je récupere tous les films
        $movies = $em->getRepository('CinheticPublicBundle:Movies')->getAllMovies();
        //je récupere toutes les villes
        $cities = $em->getRepository('CinheticPublicBundle:Cinema')->getCitiesOfMovies();
        //je récupere les prochaines séances
        $seances = $em->getRepository('CinheticPublicBundle:Sessions')->getNextSessions();
        //je récupere les catégories
        $categories = $em->getRepository('CinheticPublicBundle:Categories')->findAll();
        //je récupere les Tags
        $tags = $em->getRepository('CinheticPublicBundle:Tags')->findAll();

        $pagination = $paginator->paginate(
            $movies,
            $this->get('request')->query->get('pageone', 1) /*page number*/,
            5,
            array('pageParameterName' => 'pageone')
        );

        return $this->render('CinheticPublicBundle:Main:index.html.twig',  array(
            'movies' => $pagination,
            'cities' => $cities,
            'seances' => $seances,
            'categories' => $categories,
            'tags' => $tags,
        ));

    }

   /**
     * Search Action
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction($word = null)
    {
        $form = $this->createForm(new SearchType(), null, array(
            'action' => $this->generateUrl('Cinhetic_public_search'),
            'method' => 'GET',
        ));

        return $this->render('CinheticPublicBundle:Slots:search.html.twig',
            array('form' => $form->createView(), 'word' => $word)
        );
    }



    /**
     * Login Authentification
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        return $this->render('CinheticPublicBundle:Main:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }

}
