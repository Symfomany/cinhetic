<?php

namespace Cinhetic\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class AbstractController
 * @package Cinhetic\PublicBundle\Controller
 */

abstract class AbstractController extends Controller
{

    /**
     * Get Bundle
     * @var string
     */
    protected static $bundle = "CinheticPublicBundle";


    /**
     * Display a render to twig
     * @param null $views
     * @param array $params
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function display($views = null, $params = array()){

        if (0 === preg_match('#^(.*?\\\\Controller\\\\(.+)Controller)#', get_called_class(), $match)) {
            throw new \InvalidArgumentException(sprintf('The "%s" controller is not a valid "class::method" string.', get_called_class()));
        }

        return $this->render(self::$bundle.":".$match[2].":".$views ,  $params);
    }

    /**
     * Paginate all result
     * @param array $datas
     * @param int $limit
     * @return mixed
     */
    public function paginate($datas = array(), $limit = 50){
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $datas,
            $this->get('request')->query->get('page', 1),
            $limit
        );

        return $pagination;
    }

    /**
     * Get Repository of Entity
     * @param null $entity
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository($entity = null){
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository(self::$bundle.':'.$entity);
    }

    /**
     * Set a flash message
     * @param string $message
     * @param string $message
     */
    public function setMessage($message = "Opération bien effectuée", $criticality = "success"){
        $this->get('session')->getFlashBag()->add(
            $message,
            $criticality
        );

    }


}
