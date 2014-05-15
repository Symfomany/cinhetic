<?php

namespace Cinhetic\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Cinhetic\PublicBundle\Entity\Categories;
use FOS\RestBundle\Controller\Annotations as Rest;


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
    public function indexAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Catégories", $this->generateUrl('categories'));

        $em = $this->getDoctrine()->getManager();
        $entities = $em->createQuery(
            'SELECT a
            FROM CinheticPublicBundle:Categories a
            ORDER BY a.title ASC'
        );
        return $this->render('CinheticPublicBundle:Categories:index.html.twig', array(
            'entities' =>  $this->paginate($entities, $request->query->get('display',5))
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

        if($this->get('cinhetic_public.manager_categories')->validation($form, $entity) == TRUE){
           $this->setMessage("La catégorie a été crée");
           return $this->redirect($this->generateUrl('categories'));
        }

        return $this->render('CinheticPublicBundle:Categories:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
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
        $form = $this->get('cinhetic_public.manager_categories')->editForm($id);

        if($this->get('cinhetic_public.manager_categories')->validation($form, $id) == TRUE){
           $this->setMessage("La catégorie a été modifié");
           return $this->redirect($this->generateUrl('categories'));
        }

        return $this->render('CinheticPublicBundle:Categories:edit.html.twig', array(
            'entity'      => $id,
            'edit_form'   => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Displays a form to create a new Categories entity.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Categories", $this->generateUrl('categories'));
        $breadcrumbs->addItem("Créer");

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
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Categories", $this->generateUrl('categories'));
        $breadcrumbs->addItem("Voir");

        $deleteForm = $this->get('cinhetic_public.manager_categories')->deleteForm($id);

        return $this->render('CinheticPublicBundle:Categories:show.html.twig', array(
            'entity'      => $id,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Categories entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function editAction(Categories $id)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Categories", $this->generateUrl('categories'));
        $breadcrumbs->addItem("Editer");

        $editForm = $this->get('cinhetic_public.manager_categories')->editForm($id);
        $deleteForm = $this->get('cinhetic_public.manager_categories')->deleteForm($id);

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



    /************************************************************************************************************
     ***************************************************************** API Override Call ********************************************
     *************************************************************************************************************/

    /**
     * @Rest\View
     * Return All Categories
     */
    public function allAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('CinheticPublicBundle:Categories')->findAll();

        return array('categories' => $categories);
    }

    /**
     * @Rest\View
     * Return one Categories
     */
    public function oneAction(Categories $id)
    {
        return array('categorie' => $id);
    }


}
