<?php

namespace Cinhetic\PublicBundle\Controller;

use Cinhetic\PublicBundle\Entity\Medias;
use Cinhetic\PublicBundle\Form\SearchType;
use Doctrine\Common\Collections\ArrayCollection;
use Essence\Essence;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Cinhetic\PublicBundle\Entity\Movies;
use Cinhetic\PublicBundle\Form\MoviesType;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class MoviesController
 * @package Cinhetic\PublicBundle\Controller
 */
class MoviesController extends AbstractController
{

    /**
     * @var
     */
    protected $embed;


    /**
     * Constructor
     */
    public function __construct(){
        $this->embed = Essence::instance();
    }

    /**
     * Search Movies in Engine Search
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
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
                            'movies' => $this->paginate($movies,7)
                        ));
            }


            return $this->render('CinheticPublicBundle:Movies:searchpage.html.twig',  array(
                'form' => $form->createView(),
                'movies' => $this->paginate($movies,7)
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Films", $this->generateUrl('movies'));


        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CinheticPublicBundle:Movies')->findAll();

        return $this->render('CinheticPublicBundle:Movies:index.html.twig', array(
            'entities' => $this->paginate($entities,7),
        ));
    }


    /**
     * Get Current Movies
     * @return \Symfony\Component\HttpFoundation\Response
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
     * Get Star Movies entities.
     * @return \Symfony\Component\HttpFoundation\Response
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
     * Get Star Movies entities.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function carousselMoviesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $imgs = $em->getRepository('CinheticPublicBundle:Movies')->getAllImagesOfMovies();

        return $this->render('CinheticPublicBundle:Movies:caroussel.html.twig', array(
            'imgs' => $imgs,
        ));
    }



    /**
     * Creates a new Movies entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $entity = new Movies();
        $form = $this->get('cinhetic_public.manager_movies')->createForm($entity);

        if($this->get('cinhetic_public.manager_movies')->validation($form, $entity) == TRUE){
            $this->setMessage("Le film a été crée");
           return $this->redirect($this->generateUrl('movies')); 
        }

        return $this->render('CinheticPublicBundle:Movies:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

  

    /**
     * Edits an existing Movies entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateAction(Request $request, Movies $id)
    {
        
        $mediasembed = $this->generateEmbed($id);
        $form = $this->get('cinhetic_public.manager_movies')->editForm($id);

        if($this->get('cinhetic_public.manager_movies')->validation($form, $id) == TRUE){
            $this->setMessage("Le film a été modifié");
           return $this->redirect($this->generateUrl('actors')); 
        }

        return $this->render('CinheticPublicBundle:Movies:edit.html.twig', array(
            'entity'      => $id,
            'mediasembed'      => $mediasembed,
            'form'   => $form->createView(),
        ));

    }

    /**
     * Deletes a Movies entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
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
            $this->processRemove($id);

        }

        return $this->redirect($this->generateUrl('movies'));
    }


    /**
     * Displays a form to create a new Movies entity.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Films", $this->generateUrl('movies'));
        $breadcrumbs->addItem("Créer");

        $entity = new Movies();
        $form = $this->get('cinhetic_public.manager_movies')->createForm($entity);

        return $this->render('CinheticPublicBundle:Movies:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Finds and displays a Movies entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction(Movies $id)
    {

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Films", $this->generateUrl('movies'));
        $breadcrumbs->addItem("Voir");

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CinheticPublicBundle:Movies:show.html.twig', array(
            'entity'      => $id,
            'delete_form' => $deleteForm->createView()  
         ));
    }


    /**
     * Displays a form to edit an existing Movies entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function editAction(Movies $id)
    {
         $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Films", $this->generateUrl('movies'));
        $breadcrumbs->addItem("Editer");
       
        $form = $this->get('cinhetic_public.manager_movies')->editForm($id);
        $mediasembed = $this->generateEmbed($id);

        return $this->render('CinheticPublicBundle:Movies:edit.html.twig', array(
            'entity'      => $id,
            'mediasembed'      => $mediasembed,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Generate Embed videos
     * @param ArrayCollection $medias
     */
    protected function generateEmbed(Movies $entity){
        $medias = $entity->getMedias();
        $mediasembed = array();

        if(!empty($medias))
            foreach($medias as $media){
                if($media->getNature() == 2)
                    $mediasembed[] = $this->embed->embed($media->getVideo());
            }

        return $mediasembed;
    }




    /**
     * Get Movies entity in City.
     * @param string $ville
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cityAction($ville= "Paris")
    {
        $em = $this->getDoctrine()->getManager();
        $movies = $em->getRepository('CinheticPublicBundle:Movies')->getMoviesByCity($ville);
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $movies,
            $this->get('request')->query->get('pageone', 1) /*page number*/,
            5,
            array('pageParameterName' => 'pageone')
        );
        return $this->render('CinheticPublicBundle:Movies:city.html.twig', array(
            'city' => $ville,
            'movies' => $pagination
        ));
    }


    /**
     * Enable Movies entity.
     * @param Movies $id
     * @param int $activation
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activationAction(Movies $id, $activation = 1)
    {
        $id->setVisible((bool)$activation);
        $this->processPersist($id);

        return $this->redirect($this->generateUrl('Cinhetic_public_homepage'));
    }



    /**
     * Cover Movies entity.
     * @param Movies $id
     * @param $cover
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function coverAction(Movies $id, $cover)
    {
        $id->setCover($cover);
        $this->processPersist($id);

        return $this->redirect($this->generateUrl('Cinhetic_public_homepage'));
    }

    /**
     * Deletes a Movies by link
     * @param Movies $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deletelinkAction(Movies $id)
    {
        $this->processRemove($id);
        return $this->redirect($this->generateUrl('movies'));
    }

    /**
     * Creates a form to delete a Movies entity by id.
     * @param mixed $id The entity id
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

    /**
     * Process peristance & flush
     * @param Movies $entity
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function processPersist(Movies $entity, $message = "L'opération a bien été effectuée"){

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            $message
        );

        return $this->redirect($this->generateUrl('movies'));
    }

    /**
     * Process peristance & flush
     * @param Movies $entity
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function processRemove(Movies $entity, $message = "L'opération a bien été effectuée"){

        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            $message
        );

        return $this->redirect($this->generateUrl('movies'));
    }


    /************************************************************************************************************
     ***************************************************************** API Override Call ********************************************
     *************************************************************************************************************/

    /**
     * @Rest\View
     * Return All Movies
     */
    public function allAction()
    {
        $em = $this->getDoctrine()->getManager();
        $movies = $em->getRepository('CinheticPublicBundle:Movies')->findAll();

        return array('movies' => $movies);
    }

    /**
     * @Rest\View
     * Return one Movie
     */
    public function oneAction(Movies $id)
    {
        return array('movie' => $id);
    }


}
