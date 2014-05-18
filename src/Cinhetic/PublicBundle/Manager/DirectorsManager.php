<?php

namespace Cinhetic\PublicBundle\Manager;

use Cinhetic\PublicBundle\Entity\Directors;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class DirectorsManager
 * @package Cinhetic\PublicBundle\Manager
 */
class DirectorsManager
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
     * Form directors
     * @var \Cinhetic\PublicBundle\Form\directorsType
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
     * @param Directors $entity
     * @return bool
     */
    public function validation($form, Directors $entity){

        $form->handleRequest($this->request);

        if ($form->isValid()) {
            $this->processPersist($entity);
            return true;
        }

        return false;
    }


    /**
     * Remove directors
     * @param Directors $id
     */
    public function remove(Directors $id)
    {
        $form = $this->deleteForm($id);
        $form->handleRequest($this->request);

        if ($form->isValid()) {
            $this->processDelete($id);
            return true;
        }
    }

    /**
     * Creates a form to create a directors entity.
     * @param Directors $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    public function createForm(Directors $entity)
    {
        $form = $this->formFactory->createBuilder($this->form, $entity, array(
            'action' => $this->router->generate('directors_create'),
            'method' => 'POST',
             "attr" => array('id' => "form_director", "novalidate" => "novalidate")

        ));

        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning btn-labeled"), 'label' => 'Créer ce réalisateur'));

        return $form->getForm();
    }

    /**
     * Creates a form to edit a directors entity.
     * @param Directors $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    public function editForm(Directors $entity)
    {
        $form = $this->formFactory->createBuilder($this->form, $entity, array(
            'action' => $this->router->generate('directors_update', array('id' => $entity->getId())),
            'method' => 'POST',
            "attr" => array('id' => "form_director", "novalidate" => "novalidate")
        ));

        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning btn-labeled"), 'label' => 'Modifier ce réalisateur'));

        return $form->getForm();
    }


    /**
     * Creates a form to delete a directors entity by id.
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    public function deleteForm(Directors $id)
    {
        return $this->formFactory->createBuilder()
            ->setAction($this->router->generate('directors_delete', array('id' => $id->getId())))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer', 'attr' => array('class' => 'btn btn-danger')))
            ->getForm();
    }

    /**
     * Delete a movie
     * @param Directors $entity
     */
    protected function processDelete(Directors $entity){

        $this->em->remove($entity);
        $this->em->flush();
    }


    /**
     * Persist a movie
     * @param Directors $entity
     */
    protected function processPersist(Directors $entity){

        $this->em->persist($entity);
        $this->em->flush();
    }


}