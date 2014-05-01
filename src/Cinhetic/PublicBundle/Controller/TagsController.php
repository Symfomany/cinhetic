<?php

namespace Cinhetic\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cinhetic\PublicBundle\Entity\Tags;
use Cinhetic\PublicBundle\Form\TagsType;


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
    public function indexAction()
    {
        $entities = $this->getRepository('Tags')->findAll();

        return $this->render('CinheticPublicBundle:Tags:index.html.twig', array(
            'entities' => $entities,
        ));
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
        $this->get('cinhetic_public.manager_tags')->create($entity);


        return $this->render('CinheticPublicBundle:Tags:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Displays a form to create a new Tags entity.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
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
        $deleteForm = $this->get('cinhetic_public.manager_tags')->deleteForm($id);

        return $this->render('CinheticPublicBundle:Tags:show.html.twig', array(
            'entity'      => $id,
            'delete_form' => $deleteForm->createView(),        ));
    }


    /**
     * Displays a form to edit an existing Tags entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function editAction(Tags $id)
    {
        $editForm = $this->get('cinhetic_public.manager_tags')->editForm($id);
        $deleteForm = $this->get('cinhetic_public.manager_tags')->deleteForm($id);

        return $this->render('CinheticPublicBundle:Tags:edit.html.twig', array(
            'entity'      => $id,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
        $editForm = $this->get('cinhetic_public.manager_tags')->editForm($id);
        $this->get('cinhetic_public.manager_tags')->update($id);

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

}
