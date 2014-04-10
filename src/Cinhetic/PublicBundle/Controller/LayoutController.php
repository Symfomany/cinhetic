<?php

namespace Cinhetic\PublicBundle\Controller;

use Cinhetic\PublicBundle\Form\SearchType;
use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;


class LayoutController extends Controller
{

    /**
     * My Warning
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mywarnsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user= $this->getUser();
//        $warns = $em->getRepository('CinheticReceiptBundle:Receipt')->getWarns($user);
        $warns = 0;
        return $this->render('CinheticPublicBundle:Slots:leftmenu.html.twig',  array('warn' => (int)$warns));
    }


    /**
     * Search Action in AJAX or HTTP
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction()
    {

        $form = $this->createForm(new SearchType(), null, array(
            'action' => $this->generateUrl('Cinhetic_public_search'),
            'method' => 'GET',
        ));


        return $this->render('CinheticPublicBundle:Movies:search.html.twig',  array(
            'form' => $form->createView(),
        ));
    }


}
