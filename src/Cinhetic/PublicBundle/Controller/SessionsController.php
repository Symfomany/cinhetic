<?php

namespace Cinhetic\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cinhetic\PublicBundle\Entity\Sessions;
use Cinhetic\PublicBundle\Form\SessionsType;

/**
 * Class SessionsController
 * @package Cinhetic\PublicBundle\Controller
 */
class SessionsController extends AbstractController
{

    /**
     * Lists all Sessions entities.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $entities = $this->getRepository('Sessions')->findAll();

        return $this->render('CinheticPublicBundle:Sessions:index.html.twig', array(
            'entities' => $entities,
        ));
    }


    /**
     * Creates a new Sessions entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $entity = new Sessions();
        $form = $this->get('cinhetic_public.manager_sessions')->createForm($entity);
        $this->get('cinhetic_public.manager_sessions')->create($entity);


        return $this->render('CinheticPublicBundle:Sessions:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }



    /**
     * Displays a form to create a new Sessions entity.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $entity = new Sessions();
        $form = $this->get('cinhetic_public.manager_sessions')->createForm($entity);

        return $this->render('CinheticPublicBundle:Sessions:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Finds and displays a Sessions entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction(Sessions $id)
    {
        $deleteForm = $this->get('cinhetic_public.manager_sessions')->deleteForm($id);

        return $this->render('CinheticPublicBundle:Sessions:show.html.twig', array(
            'entity'      => $id,
            'delete_form' => $deleteForm->createView()
        ));
    }


    /**
     * Displays a form to edit an existing Sessions entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function editAction(Sessions $id)
    {
        $editForm = $this->get('cinhetic_public.manager_sessions')->editForm($id);
        $deleteForm = $this->get('cinhetic_public.manager_sessions')->deleteForm($id);

        return $this->render('CinheticPublicBundle:Sessions:edit.html.twig', array(
            'entity'      => $id,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Edits an existing Sessions entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateAction(Request $request,Sessions $id)
    {
        $deleteForm = $this->get('cinhetic_public.manager_sessions')->deleteForm($id);
        $editForm = $this->get('cinhetic_public.manager_sessions')->editForm($id);
        $this->get('cinhetic_public.manager_sessions')->update($id);



        return $this->render('CinheticPublicBundle:Sessions:edit.html.twig', array(
            'entity'      => $id,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Deletes a Sessions entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction(Request $request,Sessions $id)
    {
        $this->get('cinhetic_public.manager_sessions')->remove($id);

        return $this->redirect($this->generateUrl('sessions'));
    }

}
