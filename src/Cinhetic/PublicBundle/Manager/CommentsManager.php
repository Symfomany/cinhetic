<?php

namespace Cinhetic\PublicBundle\Manager;

use Cinhetic\PublicBundle\Entity\Comments;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class CommentsManager
 * @package Cinhetic\PublicBundle\Manager
 */
class CommentsManager
{

    /**
     * Form Factory
     * @var \Symfony\Component\Form\FormFactory
     */
    protected $em;

    /**
     * Form Factory
     * @var \Symfony\Component\Form\FormFactory
     */
    protected $formFactory;

    /**
     * Form comments
     * @var \Cinhetic\PublicBundle\Form\commentsType
     */
    protected $form;

    /**
     * Router service
     * @var \Symfony\Component\Routing\RouterInterface
     */
    protected $router;

    /**
     * Request service
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;


    /**
     * Constructor
     * @param FormFactory $formFactory
     * @param $form
     * @param RouterInterface $router
     * @param EntityManager $em
     */
    public function __construct(FormFactory $formFactory, $form, RouterInterface $router, EntityManager $em, Request $request){
        $this->formFactory = $formFactory;
        $this->form = $form;
        $this->router = $router;
        $this->em = $em;
        $this->request = $request;
    }

    /**
     * Validation
     * @param Comments $entity
     * @return bool
     */
    public function validation(Comments $entity, $validate){
        $entity->setState($validate);
        $this->em->persist($entity);
        $this->em->flush();
        return true;
    }

    /**
     * Validation
     * @param Comments $entity
     * @return bool
     */
    public function delete(Comments $entity){
        $this->processDelete($entity);
        return true;
    }

    /**
     * Update movie
     * @param Comments $entity
     * @return bool
     */
    public function update(Comments $entity){

        $editForm = $this->editForm($entity);
        $editForm->handleRequest($this->request);

        if ($editForm->isValid()) {
            $this->processPersist($entity);
            return true;
        }

    }

    /**
     * Create comments
     * @param Comments $entity
     * @return bool
     */
    public function create(Comments $entity){

        $form = $this->createForm($entity);
        $form->handleRequest($this->request);
        if ($form->isValid()) {
            $this->processPersist($entity);
            return true;
        }

    }

    /**
     * Remove comments
     * @param Comments $id
     */
    public function remove(Comments $id)
    {
        $form = $this->deleteForm($id);
        $form->handleRequest($this->request);

        if ($form->isValid()) {
            $this->processDelete($id);
            return true;
        }
    }

    /**
     * Creates a form to create a comments entity.
     * @param Comments $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    public function createForm(Comments $entity)
    {
        $form = $this->formFactory->createBuilder($this->form, $entity, array(
            'action' => $this->router->generate('comments_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning"), 'label' => 'Créer ce commentaire'));

        return $form->getForm();
    }

    /**
     * Creates a form to edit a comments entity.
     * @param Comments $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    public function editForm(Comments $entity)
    {
        $form = $this->formFactory->createBuilder($this->form, $entity, array(
            'action' => $this->router->generate('comments_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning"), 'label' => 'Modifier ce commentaire'));

        return $form->getForm();
    }


    /**
     * Creates a form to delete a comments entity by id.
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    public function deleteForm(Comments $id)
    {
        return $this->formFactory->createBuilder()
            ->setAction($this->router->generate('comments_delete', array('id' => $id->getId())))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Delete a movie
     * @param Comments $entity
     */
    protected function processDelete(Comments $entity){

        $this->em->remove($entity);
        $this->em->flush();
    }


    /**
     * Persist a movie
     * @param Comments $entity
     */
    protected function processPersist(Comments $entity){

        $this->em->persist($entity);
        $this->em->flush();
    }


}