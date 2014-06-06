<?php

namespace Cinhetic\PublicBundle\Controller;

use Cinhetic\PublicBundle\Form\SearchType;
use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LayoutController - Decorator of Layout
 * @package Cinhetic\PublicBundle\Controller
 */
class LayoutController extends AbstractController
{

    /**
     * Get alerting of emails
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function alertingAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $commentaires = $em->getRepository('CinheticPublicBundle:Comments')->getNbCommentInState(2);
        
        $response = new Response();
        $response = $this->render('CinheticPublicBundle:Slots:alerting.html.twig', array('commentaires' => $commentaires));
        $response->setPublic();
        $response->setSharedMaxAge(600);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $date = new \DateTime();
        $date->modify('+600 seconds');

        $response->setExpires($date);
        $response->setETag(md5($response->getContent()));
        $response->setPublic(); // permet de s'assurer que la réponse est publique, et qu'elle peut donc être cachée
        if ($response->isNotModified($request)) {
            return $response;
        }

        return $response;
    }


    /**
     * Get card of user
     */
    public function cardAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $stars = $session->get('stars', array());

         return $this->render('CinheticPublicBundle:Slots:card.html.twig', array(
            'stars' => isset($stars['products'])? $stars['products'] : array(),
            'total' => $stars['totalht']
        ));


    }



}
