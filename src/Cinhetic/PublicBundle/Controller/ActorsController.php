<?php

namespace Cinhetic\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Cinhetic\PublicBundle\Entity\Actors;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Cinhetic\PublicBundle\Util\WikiCreole;



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
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->createQuery(
            'SELECT a
            FROM CinheticPublicBundle:Actors a
            ORDER BY a.lastname ASC'
        );

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Acteurs", $this->generateUrl('actors'));

        return $this->render('CinheticPublicBundle:Actors:index.html.twig', array(
            'entities' => $this->paginate($entities, $request->query->get('display',5))
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

        if($this->get('cinhetic_public.manager_actors')->validation($form, $entity) == TRUE){
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
        $form = $this->get('cinhetic_public.manager_actors')->editForm($id);

        if($this->get('cinhetic_public.manager_actors')->validation($form, $id) == TRUE){
           $this->setMessage("L'acteur a été modifié");
           return $this->redirect($this->generateUrl('actors'));
        }

        return $this->render('CinheticPublicBundle:Actors:edit.html.twig', array(
            'entity'      => $id,
            'edit_form'   => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Displays a form to create a new Actors entity.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Acteurs", $this->generateUrl('actors'));
        $breadcrumbs->addItem("Créer");

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
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Acteurs", $this->generateUrl('actors'));
        $breadcrumbs->addItem("Voir");

        /*
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://en.wikipedia.org/w/api.php?action=query&titles=".$id->getFullname()."&prop=revisions&rvprop=content&rvsection=0");
        curl_setopt($ch, CURLOPT_USERAGENT, 'MonBot/1.0 (http://symfony.3wa.fr/)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        */
        /*
        $client = $this->get('guzzle.client');
        $client->setUserAgent('MonBot/1.0 (http://symfony.3wa.fr/)');
        $response = $client->get("http://fr.wikipedia.org/w/api.php?action=query&titles=".$id->getFullname()."&prop=revisions&rvprop=content&rvsection=0&format=json")->send();
        $response =  $response->json();

        $mark = new WikiCreole();
        if(!empty($response) && isset($response['query']['pages'])){
            $wiki = $mark->parse(array_shift($response['query']['pages'])['revisions'][0]['*']);
        }else{
            $wiki = "";
        }
        */
    
        return $this->render('CinheticPublicBundle:Actors:show.html.twig', array(
            'entity'      => $id,
            'movies'      => $this->paginate($id->getMovies()),
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
         $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Acteurs", $this->generateUrl('actors'));
        $breadcrumbs->addItem("Editer");

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
        $this->setMessage("L'acteur a bien été supprimé",'success');
        $this->get('cinhetic_public.manager_actors')->remove($id);

        return $this->redirect($this->generateUrl('actors'));
    }


    /**
     * Validate a actors
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function archivedAction(Actors $id)
    {

        if($this->get('cinhetic_public.manager_actors')->delete($id) == true){
            return new JsonResponse(true);
        }

        return new JsonResponse(false);
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
