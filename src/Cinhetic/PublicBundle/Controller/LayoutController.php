<?php

namespace Cinhetic\PublicBundle\Controller;

use Cinhetic\PublicBundle\Form\SearchType;
use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

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
    public function alertingAction()
    {
        $em = $this->getDoctrine()->getManager();
        $commentaires = $em->getRepository('CinheticPublicBundle:Comments')->getNbCommentInState(2);

        return $this->render('CinheticPublicBundle:Slots:alerting.html.twig', array('commentaires' => $commentaires));
    }

}
