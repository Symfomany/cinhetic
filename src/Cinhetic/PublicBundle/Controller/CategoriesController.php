<?php

namespace Cinhetic\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cinhetic\PublicBundle\Entity\Categories;
use Cinhetic\PublicBundle\Form\CategoriesType;


/**
 * Class CategoriesController
 * @package Cinhetic\PublicBundle\Controller
 */
class CategoriesController extends AbstractController
{

    /**
     * Lists all Categories entities.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $entities = $this->getRepository('Categories')->findAll();

        return $this->render('CinheticPublicBundle:Categories:index.html.twig', array(
            'entities' => $entities,
        ));
    }


    /**
     * Creates a new Categories entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $entity = new Categories();
        $form = $this->get('cinhetic_public.manager_categories')->createForm($entity);
        $this->get('cinhetic_public.manager_categories')->create($entity);


        return $this->render('CinheticPublicBundle:Categories:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Displays a form to create a new Categories entity.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $entity = new Categories();
        $form = $this->get('cinhetic_public.manager_categories')->createForm($entity);

        return $this->render('CinheticPublicBundle:Categories:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Categories entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction(Categories $id)
    {
        $deleteForm = $this->get('cinhetic_public.manager_categories')->deleteForm($id);

        return $this->render('CinheticPublicBundle:Categories:show.html.twig', array(
            'entity'      => $id,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Categories entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function editAction(Categories $id)
    {
        $editForm = $this->get('cinhetic_public.manager_categories')->editForm($id);
        $deleteForm = $this->get('cinhetic_public.manager_categories')->deleteForm($id);

        return $this->render('CinheticPublicBundle:Categories:edit.html.twig', array(
            'entity'      => $id,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Edits an existing Categories entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateAction(Request $request,Categories $id)
    {
        $deleteForm = $this->get('cinhetic_public.manager_categories')->deleteForm($id);
        $editForm = $this->get('cinhetic_public.manager_categories')->editForm($id);
        $this->get('cinhetic_public.manager_categories')->update($id);


        return $this->render('CinheticPublicBundle:Categories:edit.html.twig', array(
            'entity'      => $id,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Deletes a Categories entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction(Request $request,Categories $id)
    {
        $this->get('cinhetic_public.manager_categories')->remove($id);

        return $this->redirect($this->generateUrl('categories'));
    }

}
