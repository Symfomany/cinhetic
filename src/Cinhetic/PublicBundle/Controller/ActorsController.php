<?php

namespace Cinhetic\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Cinhetic\PublicBundle\Entity\Actors;
use FOS\RestBundle\Controller\Annotations as Rest;



/**
 * Actors controller.
 * Class ActorsController
 * @package Cinhetic\PublicBundle\Controller
 */
class ActorsController extends AbstractController
{

    /**
     * Lists all Actors entities.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $entities = $this->getRepository('Actors')->findAll();

        return $this->render('CinheticPublicBundle:Actors:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Creates a new Actors entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        $entity = new Actors();
        $form = $this->get('cinhetic_public.manager_actors')->createForm($entity);
        

        if($this->get('cinhetic_public.manager_actors')->create($entity)){
            $this->setMessage("L'acteur a été crée");
           return $this->redirect($this->generateUrl('actors'));
        }

        return $this->render('CinheticPublicBundle:Actors:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }



    /**
     * Edits an existing Actors entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateAction(Actors $id)
    {

        $deleteForm = $this->get('cinhetic_public.manager_actors')->deleteForm($id);
        $editForm = $this->get('cinhetic_public.manager_actors')->editForm($id);
        if($this->get('cinhetic_public.manager_actors')->update($id)){
            $this->setMessage("L'acteur a été modifié");
           return $this->redirect($this->generateUrl('actors'));
        }

        return $this->render('CinheticPublicBundle:Actors:edit.html.twig', array(
            'entity'      => $id,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Displays a form to create a new Actors entity.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $entity = new Actors();
        $form = $this->get('cinhetic_public.manager_actors')->createForm($entity);

        return $this->render('CinheticPublicBundle:Actors:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Finds and displays a Actors entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction(Actors $id)
    {
        $deleteForm = $this->get('cinhetic_public.manager_actors')->deleteForm($id);

        return $this->render('CinheticPublicBundle:Actors:show.html.twig', array(
            'entity'      => $id,
            'movies'      => $this->paginate($id->getMovies()),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing Actors entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function editAction(Actors $id)
    {
        $editForm = $this->get('cinhetic_public.manager_actors')->editForm($id);
        $deleteForm = $this->get('cinhetic_public.manager_actors')->deleteForm($id);

        return $this->render('CinheticPublicBundle:Actors:edit.html.twig', array(
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
    public function deleteAction(Actors $id)
    {
        $this->get('cinhetic_public.manager_actors')->remove($id);

        return $this->redirect($this->generateUrl('actors'));
    }



    /************************************************************************************************************
     ***************************************************************** API Override Call ********************************************
     *************************************************************************************************************/

    /**
     * @Rest\View
     * Return All Actors
     */
    public function allAction()
    {
        $em = $this->getDoctrine()->getManager();
        $actors = $em->getRepository('CinheticPublicBundle:Actors')->findAll();

        return array('actors' => $actors);
    }

    /**
     * @Rest\View
     * Return one Actors
     */
    public function oneAction(Actors $id)
    {
        return array('movie' => $id);
    }


}
