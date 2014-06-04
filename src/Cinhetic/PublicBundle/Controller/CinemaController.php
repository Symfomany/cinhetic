<?php

namespace Cinhetic\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Cinhetic\PublicBundle\Entity\Cinema;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


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
    public function indexAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Cinémas", $this->generateUrl('cinema'));

        $em = $this->getDoctrine()->getManager();
        $entities = $em->createQuery(
            'SELECT a
            FROM CinheticPublicBundle:Cinema a
            ORDER BY a.position ASC'
        );


        $response = new Response();
        $response = $this->render('CinheticPublicBundle:Cinema:index.html.twig', array(
            'entities' => $this->paginate($entities,$request->query->get('display',5))
        ));
        $response->setPublic();
        $response->setSharedMaxAge(600);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $date = new \DateTime();
        $date->modify('+600 seconds');

        $response->setExpires($date);
        $response->setETag(md5($response->getContent()));
        $response->setPublic(); // permet de s'assurer que la réponse est publique, et qu'elle peut donc être cachée
        $response->isNotModified($this->getRequest());

        if ($response->isNotModified($request)) {
            return $response;
        }

        return $response;

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
     * Update position
     */
    public function positionAction(Request $request)
    {
        $datas = $request->request->get('datas');
        $datas = explode('&', $datas);
        $em = $this->getDoctrine()->getManager();

        $i = 1;
        // Datas
        foreach($datas as $data){
            $data = explode('=', $data);
            if(isset($datas[1])){
                $cinema = $em->getRepository('CinheticPublicBundle:Cinema')->find($data[1]);
                if($cinema){
                    $cinema->setPosition($i);
                    $em->persist($cinema);
                    $em->flush();
                    $i++;
                }
            }
        }

        return new JsonResponse(true);
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
    public function newAction(Request $request)
    {

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Cinema", $this->generateUrl('cinema'));
        $breadcrumbs->addItem("Créer");

        $entity = new Cinema();
        $form = $this->get('cinhetic_public.manager_cinema')->createForm($entity);


        $response = new Response();
        $response = $this->render('CinheticPublicBundle:Cinema:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
        $response->setPublic();
        $response->setSharedMaxAge(600);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $date = new \DateTime();
        $date->modify('+600 seconds');

        $response->setExpires($date);
        $response->setETag(md5($response->getContent()));
        $response->setPublic(); // permet de s'assurer que la réponse est publique, et qu'elle peut donc être cachée

        if ($response->isNotModified($request)) {
            return $response;
        }

        return $response;
        
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
