<?php

namespace Cinhetic\PublicBundle\Controller;

use Cinhetic\PublicBundle\Form\CommentsMovieType;
use Symfony\Component\HttpFoundation\Request;
use Cinhetic\PublicBundle\Entity\Comments;


/**
 * Class CommentsController
 * @package Cinhetic\PublicBundle\Controller
 */
class CommentsController extends AbstractController
{


    /**
     * Lists all Comments entities.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Commentaires", $this->generateUrl('comments'));

        $entities = $this->getRepository('Comments')->findBy(array(), array('dateCreated' => 'DESC'));
        $inwaiting = $this->getRepository('Comments')->findBy(array('state' => 1), array('dateCreated' => 'DESC'));
        $actived = $this->getRepository('Comments')->findBy(array('state' => 2), array('dateCreated' => 'DESC'));
        $removed = $this->getRepository('Comments')->findBy(array('state' => 0), array('dateCreated' => 'DESC'));

        return $this->render('CinheticPublicBundle:Comments:index.html.twig', array(
            'entities' => $this->paginate($entities,$request->query->get('display',5)),
            'inwaiting' =>$inwaiting,
            'actived' => $actived,
            'removed' => $removed
        ));
    }



    /**
     * Creates a new Comments entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $entity = new Comments();
        $form = $this->get('cinhetic_public.manager_comments')->createForm($entity);
        $this->get('cinhetic_public.manager_comments')->create($entity);


        return $this->render('CinheticPublicBundle:Comments:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Comments entity.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Commentaires", $this->generateUrl('comments'));
        $breadcrumbs->addItem("Créer");

        $entity = new Comments();
        $form = $this->get('cinhetic_public.manager_comments')->createForm($entity);

        return $this->render('CinheticPublicBundle:Comments:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Displays a form to create a new Comments entity.
     * @param Request $request
     * @param null $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function commentMovieAction(Request $request, $id = null)
    {
        $form = $this->createForm(new CommentsMovieType(), null, array(
            'action' => $this->generateUrl('comments_movies'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning"), 'label' => 'Ajouter le commentaire'));

        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity = new Comments();

            $movie = $form['movie']->getData();
            $movie = $em->getRepository('CinheticPublicBundle:Movies')->find($movie);

            if (!$movie) {
                throw $this->createNotFoundException('Unable to find Movies entity.');
            }

            $user = $this->getUser();

            $content = $form['content']->getData();
            $note = $form['note']->getData();
            $entity->setMovie($movie);
            $entity->setContent($content);
            $entity->setUser($user); //facultatif pour ceux qui utilise FOSUserBundle et la sécurité
            $entity->setNote($note);
            $em->persist($entity);
            $em->flush();

            //messages flash se jouant qu'une seule fois
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre commentaire a bien été ajouté'
            );

            //redirections
            return $this->redirect($this->generateUrl('Cinhetic_public_homepage'));
        }

        return $this->render('CinheticPublicBundle:Comments:commentMovie.html.twig', array(
            'id' => $id,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Finds and displays a Comments entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction(Comments $id)
    {
         $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Commentaires", $this->generateUrl('comments'));
        $breadcrumbs->addItem("Voir");

        $deleteForm = $this->get('cinhetic_public.manager_comments')->deleteForm($id);

        return $this->render('CinheticPublicBundle:Comments:show.html.twig', array(
            'entity'      => $id,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Validate a comment
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function validationAction(Comments $id, $validate)
    {

        if($this->get('cinhetic_public.manager_comments')->validation($id, $validate) == true){
            $this->setMessage("Le commentaire a été modéré");
        }

        return $this->redirect($this->generateUrl('comments'));
    }


    /**
     * Displays a form to edit an existing Comments entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function editAction(Comments $id)
    {
         $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Commentaires", $this->generateUrl('comments'));
        $breadcrumbs->addItem("Editer");

        $editForm = $this->get('cinhetic_public.manager_comments')->editForm($id);
        $deleteForm = $this->get('cinhetic_public.manager_comments')->deleteForm($id);


        return $this->render('CinheticPublicBundle:Comments:edit.html.twig', array(
            'entity'      => $id,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Edits an existing Comments entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateAction(Request $request,Comments $id)
    {
        $deleteForm = $this->get('cinhetic_public.manager_comments')->deleteForm($id);
        $editForm = $this->get('cinhetic_public.manager_comments')->editForm($id);
        $this->get('cinhetic_public.manager_comments')->update($id);


        return $this->render('CinheticPublicBundle:Comments:edit.html.twig', array(
            'entity'      => $id,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Remove a Comments
     */
    public function removeAction(Comments $id)
    {
        if($this->get('cinhetic_public.manager_comments')->delete($id) == true){
            $this->setMessage("Le commentaire a été supprimé");
        }
        return $this->redirect($this->generateUrl('comments'));
    }


    /**
     * Deletes a Comments entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction(Request $request,Comments $id)
    {
        $this->get('cinhetic_public.manager_comments')->remove($id);

        return $this->redirect($this->generateUrl('comments'));
    }

}
