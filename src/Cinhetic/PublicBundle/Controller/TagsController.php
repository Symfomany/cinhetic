<?php

namespace Cinhetic\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Cinhetic\PublicBundle\Entity\Tags;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class TagsController
 * @package Cinhetic\PublicBundle\Controller
 */
class TagsController extends AbstractController
{


    /**
     * Lists all Tags entities.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Tags", $this->generateUrl('tags'));

        $em = $this->getDoctrine()->getManager();
        $entities = $em->createQuery(
            'SELECT a
            FROM CinheticPublicBundle:Tags a
            ORDER BY a.word ASC'
        );

        $response = new Response();
        $response = $this->render('CinheticPublicBundle:Tags:index.html.twig', array(
            'entities' => $this->paginate($entities, $request->query->get('display',5))
        ));
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
     * Creates a new Tags entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $entity = new Tags();
        $form = $this->get('cinhetic_public.manager_tags')->createForm($entity);

        if($this->get('cinhetic_public.manager_tags')->validation($form, $entity) == TRUE){
           $this->setMessage("Le tag a été crée");
           return $this->redirect($this->generateUrl('tags'));
        }

        return $this->render('CinheticPublicBundle:Tags:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Edits an existing Tags entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateAction(Request $request,Tags $id)
    {
        $deleteForm = $this->get('cinhetic_public.manager_tags')->deleteForm($id);
        $form = $this->get('cinhetic_public.manager_tags')->editForm($id);

        if($this->get('cinhetic_public.manager_tags')->validation($form, $id) == TRUE){
           $this->setMessage("Le tag a été crée");
           return $this->redirect($this->generateUrl('tags'));
        }

        return $this->render('CinheticPublicBundle:Tags:edit.html.twig', array(
            'entity'      => $id,
            'edit_form'   => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Displays a form to create a new Tags entity.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Tags", $this->generateUrl('tags'));
        $breadcrumbs->addItem("Créer");

        $entity = new Tags();
        $form = $this->get('cinhetic_public.manager_tags')->createForm($entity);

        return $this->render('CinheticPublicBundle:Tags:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Finds and displays a Tags entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction(Tags $id)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Tags", $this->generateUrl('tags'));
        $breadcrumbs->addItem("Voir");

        $deleteForm = $this->get('cinhetic_public.manager_tags')->deleteForm($id);

        return $this->render('CinheticPublicBundle:Tags:show.html.twig', array(
            'entity'      => $id,
            'delete_form' => $deleteForm->createView(),    
            ));
    }


    /**
     * Displays a form to edit an existing Tags entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function editAction(Tags $id)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Tags", $this->generateUrl('tags'));
        $breadcrumbs->addItem("Editer");

        $editForm = $this->get('cinhetic_public.manager_tags')->editForm($id);
        $deleteForm = $this->get('cinhetic_public.manager_tags')->deleteForm($id);

        return $this->render('CinheticPublicBundle:Tags:edit.html.twig', array(
            'entity'      => $id,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }



    /**
     * Deletes a Tags entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction(Request $request,Tags $id)
    {
        $this->get('cinhetic_public.manager_tags')->remove($id);

        return $this->redirect($this->generateUrl('tags'));
    }


    /************************************************************************************************************
     ***************************************************************** API Override Call ********************************************
     *************************************************************************************************************/

    /**
     * @Rest\View
     * Return All Tags
     */
    public function allAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tags = $em->getRepository('CinheticPublicBundle:Tags')->findAll();

        return array('tags' => $tags);
    }

    /**
     * @Rest\View
     * Return one Tag
     */
    public function oneAction(Tags $id)
    {
        return array('tag' => $id);
    }



}
