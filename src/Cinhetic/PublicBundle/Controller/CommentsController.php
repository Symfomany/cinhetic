<?php

namespace Cinhetic\PublicBundle\Controller;

use Cinhetic\PublicBundle\Form\CommentsMovieType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cinhetic\PublicBundle\Entity\Comments;
use Cinhetic\PublicBundle\Form\CommentsType;

/**
 * Comments controller.
 *
 */
class CommentsController extends Controller
{

    /**
     * Lists all Comments entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CinheticPublicBundle:Comments')->findAll();

        return $this->render('CinheticPublicBundle:Comments:index.html.twig', array(
            'entities' => $entities,
        ));
    }


    /**
     * Creates a new Comments entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Comments();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('comments_show', array('id' => $entity->getId())));
        }

        return $this->render('CinheticPublicBundle:Comments:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Comments entity.
    *
    * @param Comments $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Comments $entity)
    {
        $form = $this->createForm(new CommentsType(), $entity, array(
            'action' => $this->generateUrl('comments_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning"), 'label' => 'Créer ce commentaire'));

        return $form;
    }

    /**
     * Displays a form to create a new Comments entity.
     *
     */
    public function newAction()
    {
        $entity = new Comments();
        $form   = $this->createCreateForm($entity);

        return $this->render('CinheticPublicBundle:Comments:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Comments entity.
     *
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
            //facultatif pour ceux qui utilise FOSUserBundle et la sécurité
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
        $errors = $this->get('validator')->validate($form);


        foreach( $errors as $error )
        {
//            echo   $error->getPropertyPath();
//            echo   $error->getMessage();
        }


        return $this->render('CinheticPublicBundle:Comments:commentMovie.html.twig', array(
            'id' => $id,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Comments entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CinheticPublicBundle:Comments')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comments entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CinheticPublicBundle:Comments:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Comments entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CinheticPublicBundle:Comments')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comments entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CinheticPublicBundle:Comments:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Comments entity.
    *
    * @param Comments $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Comments $entity)
    {
        $form = $this->createForm(new CommentsType(), $entity, array(
            'action' => $this->generateUrl('comments_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning"), 'label' => 'Modifier ce cinéma'));

        return $form;
    }
    /**
     * Edits an existing Comments entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CinheticPublicBundle:Comments')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comments entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('comments_edit', array('id' => $id)));
        }

        return $this->render('CinheticPublicBundle:Comments:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Comments entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CinheticPublicBundle:Comments')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Comments entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('comments'));
    }

    /**
     * Creates a form to delete a Comments entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comments_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
