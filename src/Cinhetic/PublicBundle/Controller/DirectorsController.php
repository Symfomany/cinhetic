<?php

namespace Cinhetic\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Cinhetic\PublicBundle\Entity\Directors;
use FOS\RestBundle\Controller\Annotations as Rest;


/**
 * Class DirectorsController
 * @package Cinhetic\PublicBundle\Controller
 */
class DirectorsController extends AbstractController
{


    /**
     * Lists all Directors entities.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $entities = $this->getRepository('Directors')->findAll();

        return $this->render('CinheticPublicBundle:Directors:index.html.twig', array(
            'entities' => $entities,
        ));
    }


    /**
     * Creates a new Directors entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $entity = new Directors();
        $form = $this->get('cinhetic_public.manager_directors')->createForm($entity);
        $this->get('cinhetic_public.manager_directors')->create($entity);

        return $this->render('CinheticPublicBundle:Directors:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }



    /**
     * Displays a form to create a new Directors entity.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $entity = new Directors();
        $form = $this->get('cinhetic_public.manager_directors')->createForm($entity);

        return $this->render('CinheticPublicBundle:Directors:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Directors entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction(Directors $id)
    {
        $deleteForm = $this->get('cinhetic_public.manager_directors')->deleteForm($id);

        return $this->render('CinheticPublicBundle:Directors:show.html.twig', array(
            'entity'      => $id,
            'movies'      => $this->paginate($id->getMovies()),
            'delete_form' => $deleteForm->createView(),        ));
    }


    /**
     * Displays a form to edit an existing Directors entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function editAction(Directors $id)
    {
        $editForm = $this->get('cinhetic_public.manager_directors')->editForm($id);
        $deleteForm = $this->get('cinhetic_public.manager_directors')->deleteForm($id);


        return $this->render('CinheticPublicBundle:Directors:edit.html.twig', array(
            'entity'      => $id,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Edits an existing Directors entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateAction(Request $request,Directors $id)
    {
        $deleteForm = $this->get('cinhetic_public.manager_directors')->deleteForm($id);
        $editForm = $this->get('cinhetic_public.manager_directors')->editForm($id);
        $this->get('cinhetic_public.manager_directors')->update($id);

        return $this->render('CinheticPublicBundle:Directors:edit.html.twig', array(
            'entity'      => $id,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Deletes a Directors entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction(Request $request,Directors $id)
    {
        $this->get('cinhetic_public.manager_directors')->remove($id);

        return $this->redirect($this->generateUrl('directors'));
    }



    /************************************************************************************************************
     ***************************************************************** API Override Call ********************************************
     *************************************************************************************************************/

    /**
     * @Rest\View
     * Return All Directors
     */
    public function allAction()
    {
        $em = $this->getDoctrine()->getManager();
        $directors = $em->getRepository('CinheticPublicBundle:Directors')->findAll();

        return array('directors' => $directors);
    }

    /**
     * @Rest\View
     * Return one Directors
     */
    public function oneAction(Directors $id)
    {
        return array('directors' => $id);
    }

}
