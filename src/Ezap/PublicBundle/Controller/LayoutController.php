<?php

namespace Ezap\PublicBundle\Controller;

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
//        $warns = $em->getRepository('EzapReceiptBundle:Receipt')->getWarns($user);
        $warns = 0;
        return $this->render('EzapPublicBundle:Slots:leftmenu.html.twig',  array('warn' => (int)$warns));
    }

}
