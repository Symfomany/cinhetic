<?php

namespace Cinhetic\PublicBundle\Manager;

use Cinhetic\PublicBundle\Entity\sessions;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class SessionsManager
 * @package Cinhetic\PublicBundle\Manager
 */
class SessionsManager
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
     * Form sessions
     * @var \Cinhetic\PublicBundle\Form\sessionsType
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
     * Update movie
     * @param Sessions $entity
     * @return bool
     */
    public function update(Sessions $entity){

        $editForm = $this->editForm($entity);
        $editForm->handleRequest($this->request);

        if ($editForm->isValid()) {
            $this->processPersist($entity);
            return true;
        }

    }

    /**
     * Create sessions
     * @param Sessions $entity
     * @return bool
     */
    public function create(Sessions $entity){

        $form = $this->createForm($entity);
        $form->handleRequest($this->request);
        if ($form->isValid()) {
            $this->processPersist($entity);
            return true;
        }

    }

    /**
     * Remove sessions
     * @param Sessions $id
     */
    public function remove(Sessions $id)
    {
        $form = $this->deleteForm($id);
        $form->handleRequest($this->request);

        if ($form->isValid()) {
            $this->processDelete($id);
            return true;
        }
    }

    /**
     * Creates a form to create a sessions entity.
     * @param Sessions $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    public function createForm(Sessions $entity)
    {
        $form = $this->formFactory->createBuilder($this->form, $entity, array(
            'action' => $this->router->generate('sessions_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning"), 'label' => 'Créer cette séance'));

        return $form->getForm();
    }

    /**
     * Creates a form to edit a sessions entity.
     * @param Sessions $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    public function editForm(Sessions $entity)
    {
        $form = $this->formFactory->createBuilder($this->form, $entity, array(
            'action' => $this->router->generate('sessions_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning"), 'label' => 'Modifier cette séance'));

        return $form->getForm();
    }


    /**
     * Creates a form to delete a sessions entity by id.
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    public function deleteForm(Sessions $id)
    {
        return $this->formFactory->createBuilder()
            ->setAction($this->router->generate('sessions_delete', array('id' => $id->getId())))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Delete a Session
     * @param Sessions $entity
     */
    protected function processDelete(Sessions $entity){

        $this->em->remove($entity);
        $this->em->flush();
    }


    /**
     * Persist a Session
     * @param Sessions $entity
     */
    protected function processPersist(Sessions $entity){

        $this->em->persist($entity);
        $this->em->flush();
    }


}