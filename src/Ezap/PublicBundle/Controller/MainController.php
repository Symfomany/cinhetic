<?php

namespace Ezap\PublicBundle\Controller;

use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;


class MainController extends Controller
{
    /**
     * Main Dashboard
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $movies = $em->getRepository('EzapPublicBundle:Movies')->findAll();

        $pagination = $paginator->paginate(
            $movies,
            $this->get('request')->query->get('pageone', 1) /*page number*/,
            5,
            array('pageParameterName' => 'pageone')
        );

        return $this->render('EzapPublicBundle:Main:index.html.twig',  array('movies' => $pagination));

    }

   /**
     * Search Action in AJAX or HTTP
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction($ajax = false)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $request = $this->get('request');
        $movies = array();

        if($ajax === FALSE){
            $word = $request->query->get('word');
            $movies = $em->getRepository('EzapPublicBundle:Movies')->search($word);

            $pagination = $paginator->paginate(
                $movies,
                $this->get('request')->query->get('pageone', 1) /*page number*/,
                5,
                array('pageParameterName' => 'pageone')
            );

            return $this->render('EzapPublicBundle:Main:search.html.twig',  array('movies' => $pagination));
        } else{

            return new JsonResponse($movies);
        }

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
        return $this->render('EzapPublicBundle:Main:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }

}
