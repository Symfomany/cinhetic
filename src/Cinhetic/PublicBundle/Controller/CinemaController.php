<?php

namespace Cinhetic\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Cinhetic\PublicBundle\Entity\Cinema;
use FOS\RestBundle\Controller\Annotations as Rest;


/**
 * Class CinemaController
 * @package Cinhetic\PublicBundle\Controller
 */
class CinemaController extends AbstractController
{

    /**
     * Lists all Cinema entities.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Cinémas", $this->generateUrl('cinema'));

        $em = $this->getDoctrine()->getManager();
        $entities = $em->createQuery(
            'SELECT a
            FROM CinheticPublicBundle:Cinema a
            ORDER BY a.title ASC'
        );
        return $this->render('CinheticPublicBundle:Cinema:index.html.twig', array(
            'entities' => $this->paginate($entities,7),
        ));
    }


    /**
     * Creates a new Cinema entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $entity = new Cinema();
        $form = $this->get('cinhetic_public.manager_cinema')->createForm($entity);
        if($this->get('cinhetic_public.manager_cinema')->validation($form, $entity) == TRUE){
           $this->setMessage("Le cinéma a été crée");
           return $this->redirect($this->generateUrl('cinema'));
        }

        return $this->render('CinheticPublicBundle:Cinema:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }



    /**
     * Edits an existing Cinema entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateAction(Request $request,Cinema $id)
    {
        $deleteForm = $this->get('cinhetic_public.manager_cinema')->deleteForm($id);
        $form = $this->get('cinhetic_public.manager_cinema')->editForm($id);
        
        if($this->get('cinhetic_public.manager_cinema')->validation($form, $id) == TRUE){
           $this->setMessage("Le cinéma a été modifié");
           return $this->redirect($this->generateUrl('cinema'));
        }

        return $this->render('CinheticPublicBundle:Cinema:edit.html.twig', array(
            'entity'      => $id,
            'edit_form'   => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Displays a form to create a new Cinema entity.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Cinema", $this->generateUrl('cinema'));
        $breadcrumbs->addItem("Créer");

        $entity = new Cinema();
        $form = $this->get('cinhetic_public.manager_cinema')->createForm($entity);

        return $this->render('CinheticPublicBundle:Cinema:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Finds and displays a Cinema entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction(Cinema $id)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Cinema", $this->generateUrl('cinema'));
        $breadcrumbs->addItem("Voir");

        $deleteForm = $this->get('cinhetic_public.manager_cinema')->deleteForm($id);

        // TODO : create a real cover
        $cover = array();
        foreach ($id->getMovies() as $movie) {
            $cover[$movie->getId()] = NULL;
            foreach ($movie->getMedias() as $picture) {
                if ($picture->getNature())
                {
                    $cover[$movie->getId()] = $picture->getPicture();
                    break;
                }
            }
        }

        return $this->render('CinheticPublicBundle:Cinema:show.html.twig', array(
            'entity'      => $id,
            'cover' => $cover,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Cinema entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function editAction(Cinema $id)
    {
         $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Cinema", $this->generateUrl('cinema'));
        $breadcrumbs->addItem("Editer");

        $editForm = $this->get('cinhetic_public.manager_cinema')->editForm($id);
        $deleteForm = $this->get('cinhetic_public.manager_cinema')->deleteForm($id);

        return $this->render('CinheticPublicBundle:Cinema:edit.html.twig', array(
            'entity'      => $id,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Deletes a Cinema entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction(Request $request,Cinema $id)
    {
        $this->get('cinhetic_public.manager_cinema')->remove($id);

        return $this->redirect($this->generateUrl('cinema'));
    }


    /************************************************************************************************************
     ***************************************************************** API Override Call ********************************************
     *************************************************************************************************************/

    /**
     * @Rest\View
     * Return All Cinema
     */
    public function allAction()
    {
        $em = $this->getDoctrine()->getManager();
        $cinemas = $em->getRepository('CinheticPublicBundle:Cinema')->findAll();

        return array('cinemas' => $cinemas);
    }

    /**
     * @Rest\View
     * Return one Cinema
     */
    public function oneAction(Cinema $id)
    {
        return array('cinema' => $id);
    }

}
