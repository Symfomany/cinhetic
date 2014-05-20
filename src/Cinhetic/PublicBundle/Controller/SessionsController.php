<?php

namespace Cinhetic\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Cinhetic\PublicBundle\Entity\Sessions;
use FOS\RestBundle\Controller\Annotations as Rest;

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
    public function indexAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Séances", $this->generateUrl('sessions'));

        $em = $this->getDoctrine()->getManager();
        $entities = $em->createQuery(
            'SELECT a
            FROM CinheticPublicBundle:Sessions a
            JOIN a.movies m
            JOIN a.cinema c
            ORDER BY a.dateSession ASC'
        );
        return $this->render('CinheticPublicBundle:Sessions:index.html.twig', array(
            'entities' => $this->paginate($entities, $request->query->get('display',5))
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

        if($this->get('cinhetic_public.manager_sessions')->validation($form, $entity) ==  true){
            $this->setMessage("La séance a été crée");
            return $this->redirect($this->generateUrl('sessions')); 
        }


        return $this->render('CinheticPublicBundle:Sessions:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }



    /**
     * Edits an existing Sessions entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateAction(Request $request, Sessions $id)
    {
        $deleteForm = $this->get('cinhetic_public.manager_sessions')->deleteForm($id);
        $form = $this->get('cinhetic_public.manager_sessions')->editForm($id);

        if($this->get('cinhetic_public.manager_sessions')->validation($form, $id) ==  true){
            $this->setMessage("La séance a été crée");
            return $this->redirect($this->generateUrl('sessions')); 
        }

        return $this->render('CinheticPublicBundle:Sessions:edit.html.twig', array(
            'entity'      => $id,
            'edit_form'   => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new Sessions entity.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Séances", $this->generateUrl('sessions'));
        $breadcrumbs->addItem("Créer");

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
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Séances", $this->generateUrl('sessions'));
        $breadcrumbs->addItem("Voir");

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
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Séances", $this->generateUrl('sessions'));
        $breadcrumbs->addItem("Editer");

        $editForm = $this->get('cinhetic_public.manager_sessions')->editForm($id);
        $deleteForm = $this->get('cinhetic_public.manager_sessions')->deleteForm($id);

        $editForm->get('hourSession')->setData($id->getDateSession()->format('H:i a'));
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


    /************************************************************************************************************
     ***************************************************************** API Override Call ********************************************
     *************************************************************************************************************/

    /**
     * @Rest\View
     * Return All Sessions
     */
    public function allAction()
    {
        $em = $this->getDoctrine()->getManager();
        $sessions = $em->getRepository('CinheticPublicBundle:Sessions')->findAll();

        return array('sessions' => $sessions);
    }

    /**
     * @Rest\View
     * Return one Sessions
     */
    public function oneAction(Sessions $id)
    {
        return array('session' => $id);
    }


}
