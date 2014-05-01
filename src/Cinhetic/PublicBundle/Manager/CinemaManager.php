<?php

namespace Cinhetic\PublicBundle\Manager;

use Cinhetic\PublicBundle\Entity\Cinema;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class CinemaManager
 * @package Cinhetic\PublicBundle\Manager
 */
class CinemaManager
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
     * Form cinema
     * @var \Cinhetic\PublicBundle\Form\cinemaType
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
     * @param Cinema $entity
     * @return bool
     */
    public function update(Cinema $entity){

        $editForm = $this->editForm($entity);
        $editForm->handleRequest($this->request);

        if ($editForm->isValid()) {
            $this->processPersist($entity);
            return true;
        }

    }

    /**
     * Create cinema
     * @param Cinema $entity
     * @return bool
     */
    public function create(Cinema $entity){

        $form = $this->createForm($entity);
        $form->handleRequest($this->request);
        if ($form->isValid()) {
            $this->processPersist($entity);
            return true;
        }

    }

    /**
     * Remove cinema
     * @param Cinema $id
     */
    public function remove(Cinema $id)
    {
        $form = $this->deleteForm($id);
        $form->handleRequest($this->request);

        if ($form->isValid()) {
            $this->processDelete($id);
            return true;
        }
    }

    /**
     * Creates a form to create a cinema entity.
     * @param Cinema $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    public function createForm(Cinema $entity)
    {
        $form = $this->formFactory->createBuilder($this->form, $entity, array(
            'action' => $this->router->generate('cinema_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning"), 'label' => 'Créer ce cinéma'));

        return $form->getForm();
    }

    /**
     * Creates a form to edit a cinema entity.
     * @param Cinema $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    public function editForm(Cinema $entity)
    {
        $form = $this->formFactory->createBuilder($this->form, $entity, array(
            'action' => $this->router->generate('cinema_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning"), 'label' => 'Modifier ce cinéma'));

        return $form->getForm();
    }


    /**
     * Creates a form to delete a cinema entity by id.
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    public function deleteForm(Cinema $id)
    {
        return $this->formFactory->createBuilder()
            ->setAction($this->router->generate('cinema_delete', array('id' => $id->getId())))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Delete a movie
     * @param Cinema $entity
     */
    protected function processDelete(Cinema $entity){

        $this->em->remove($entity);
        $this->em->flush();
    }


    /**
     * Persist a movie
     * @param Cinema $entity
     */
    protected function processPersist(Cinema $entity){

        $this->em->persist($entity);
        $this->em->flush();
    }


}