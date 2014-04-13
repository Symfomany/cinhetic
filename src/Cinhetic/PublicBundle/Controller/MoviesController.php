<?php

namespace Cinhetic\PublicBundle\Controller;

use Cinhetic\PublicBundle\Form\SearchType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cinhetic\PublicBundle\Entity\Movies;
use Cinhetic\PublicBundle\Form\MoviesType;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Movies controller.
 *
 */
class MoviesController extends Controller
{


    /**
     * Search Movies in Engine Search
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction($ajax = false)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $paginator = $this->get('knp_paginator');
        $movies = $em->getRepository('CinheticPublicBundle:Movies')->findAll();
        $ajax = $request->query->get('ajax');

        if(!$ajax){

            $form = $this->createForm(new SearchType(), null, array(
                'action' => $this->generateUrl('Cinhetic_public_search'),
                'method' => 'POST',
            ));

            $form->handleRequest($request);

            if($form->isValid()){
                        $word = $form->get('search')->getData();

                        //with DQL Repository
                        //$movies = $em->getRepository('CinheticPublicBundle:Movies')->search($word);

                        //Wildcard : With Elastica
                        $finderMovies = $this->container->get('fos_elastica.finder.website.movies');
                        $movies = $finderMovies->find($word);


                        $pagination = $paginator->paginate(
                            $movies,
                            $this->get('request')->query->get('pageone', 1) /*page number*/,
                            5,
                            array('pageParameterName' => 'pageone')
                        );

                        return $this->render('CinheticPublicBundle:Movies:searchpage.html.twig',  array(
                            'form' => $form->createView(),
                            'movies' => $pagination,
                        ));
            }

            $pagination = $paginator->paginate(
                $movies,
                $this->get('request')->query->get('pageone', 1) /*page number*/,
                5,
                array('pageParameterName' => 'pageone')
            );

            return $this->render('CinheticPublicBundle:Movies:searchpage.html.twig',  array(
                'form' => $form->createView(),
                'movies' => $pagination,
            ));

        }else{
            $word = $request->query->get('word');
            $finderMovies = $this->container->get('fos_elastica.finder.website.movies');
            $movies = $finderMovies->find($word);

            $results_final = array();
            if (!empty($movies))
                foreach ($movies as $movie)
                    $results_final[] = array(
                        'nom' => $movie->getTitle() ."  " . $movie->getCategory()->getTitle() . "(" . $movie->getAnnee() . ")",
                        'url' => $this->generateUrl('movies_show', array('word' => $word, "id" => $movie->getId()))
                    );

            return new JsonResponse($results_final);
        }
    }



    /**
     * Lists all Movies
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CinheticPublicBundle:Movies')->findAll();

        return $this->render('CinheticPublicBundle:Movies:index.html.twig', array(
            'entities' => $entities,
        ));
    }


    /**
     * Get Current Movies
     */
    public function currentMoviesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CinheticPublicBundle:Movies')->getCurrentMovies();

        return $this->render('CinheticPublicBundle:Movies:current.html.twig', array(
            'entities' => $entities,
        ));
    }



    /**
     * get Star Movies entities.
     *
     */
    public function starsMoviesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CinheticPublicBundle:Movies')->getStarMovies();

        return $this->render('CinheticPublicBundle:Movies:stars.html.twig', array(
            'entities' => $entities,
        ));
    }



    /**
     * get Star Movies entities.
     *
     */
    public function carousselMoviesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CinheticPublicBundle:Movies')->getCoverMovies();

        return $this->render('CinheticPublicBundle:Movies:caroussel.html.twig', array(
            'entities' => $entities,
        ));
    }



    /**
     * Creates a new Movies entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Movies();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('movies_show', array('id' => $entity->getId())));
        }

        return $this->render('CinheticPublicBundle:Movies:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Movies entity.
    *
    * @param Movies $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Movies $entity)
    {
        $form = $this->createForm(new MoviesType(), $entity, array(
            'action' => $this->generateUrl('movies_create'),
            'attr' => array('id' => 'handlemovie',  'novalidate' => "novalidate"),
            'method' => 'POST'
        ));

        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning"), 'label' => 'Créer ce film'));

        return $form;
    }

    /**
     * Displays a form to create a new Movies entity.
     *
     */
    public function newAction()
    {
        $entity = new Movies();
        $form   = $this->createCreateForm($entity);

        return $this->render('CinheticPublicBundle:Movies:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Movies entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CinheticPublicBundle:Movies')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Movies entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CinheticPublicBundle:Movies:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Movies entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CinheticPublicBundle:Movies')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Movies entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CinheticPublicBundle:Movies:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Movies entity.
    *
    * @param Movies $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Movies $entity)
    {
        $form = $this->createForm(new MoviesType(), $entity, array(
            'action' => $this->generateUrl('movies_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning"), 'label' => 'Modifier ce film'));

        return $form;
    }


    /**
     * Edits an existing Movies entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CinheticPublicBundle:Movies')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Movies entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('movies_edit', array('id' => $id)));
        }

        return $this->render('CinheticPublicBundle:Movies:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Deletes a Movies entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CinheticPublicBundle:Movies')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Movies entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('movies'));
    }


    /**
     * Get Movies entity in City.
     *
     */
    public function cityAction($ville= "Paris")
    {
        $em = $this->getDoctrine()->getManager();
        $movies = $em->getRepository('CinheticPublicBundle:Movies')->getMoviesByCity($ville);


        return $this->render('CinheticPublicBundle:Movies:city.html.twig', array(
            'city' => $ville,
            'movies' => $movies
        ));
    }



    /**
     * Enable Movies entity.
     *
     */
    public function activationAction(Movies $id, $activation)
    {
        $em = $this->getDoctrine()->getManager();

        $id->setVisible($activation);
        $em->persist($id);
        $em->flush();

        //messages flash se jouant qu'une seule fois
        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre modification sur l\'activation a bien été prise en compte'
        );

        //redirections
        return $this->redirect($this->generateUrl('Cinhetic_public_homepage'));
    }



    /**
     * Cover Movies entity.
     *
     */
    public function coverAction(Movies $id, $cover)
    {
        $em = $this->getDoctrine()->getManager();

        $id->setCover($cover);
        $em->persist($id);
        $em->flush();

        //messages flash se jouant qu'une seule fois
        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre mise en avant a bien été prise en compte'
        );

        //redirections
        return $this->redirect($this->generateUrl('Cinhetic_public_homepage'));
    }


    /**
     * Deletes a Movies by link
     *
     */
    public function deletelinkAction(Movies $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirect($this->generateUrl('movies'));
    }

    /**
     * Creates a form to delete a Movies entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('movies_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }



    /************************************************************************************************************
     ***************************************************************** API Override Call ********************************************
     *************************************************************************************************************/

    /**
     * @Rest\View
     * Return All Receipts
     */
    public function allAction()
    {
        $em = $this->getDoctrine()->getManager();
        $movies = $em->getRepository('CinheticPublicBundle:Movies')->findAll();

        return array('movies' => $movies);
    }

    /**
     * @Rest\View
     * Return one Receipt
     */
    public function oneAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $movie = $em->getRepository('CinheticPublicBundle:Movie')->find($id);

        return array('movie' => $movie);
    }

}
