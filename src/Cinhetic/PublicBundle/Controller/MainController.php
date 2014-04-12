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
     * Homepage Get Started
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        return $this->render('CinheticPublicBundle:Main:home.html.twig');
    }


    /**
     * Main Dashboard Homepage
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator'); //je mets en place la pagination

        $movies = $em->getRepository('CinheticPublicBundle:Movies')->getAllMovies();
        $cities = $em->getRepository('CinheticPublicBundle:Cinema')->getCitiesOfMovies();
        $seances = $em->getRepository('CinheticPublicBundle:Sessions')->getNextSessions();
        $categories = $em->getRepository('CinheticPublicBundle:Categories')->findAll();
        $tags = $em->getRepository('CinheticPublicBundle:Tags')->findAll();

        $pagination = $paginator->paginate(
            $movies,
            $this->get('request')->query->get('page', 1) /*page number*/,
            5
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
    public function loginAction()
    {
        $request = $this->getRequest();
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

}
