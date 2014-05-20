<?php

namespace Cinhetic\PublicBundle\Manager;

use Cinhetic\PublicBundle\Entity\Actors;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ActorsManager
 * @package Cinhetic\PublicBundle\Manager
 */
class ActorsManager
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
     * Form Actors
     * @var \Cinhetic\PublicBundle\Form\ActorsType
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
     * @param Actors $entity
     * @return bool
     */
    public function delete(Actors $entity){
        $this->processDelete($entity);
        return true;
    }


    /**
     * Validation
     * @param Comments $entity
     * @return bool
     */
    public function validate(Actors $entity, $validate){
        $entity->set($validate);
        $this->em->persist($entity);
        $this->em->flush();
        return true;
    }

    
    /**
     * Create Actors
     * @param Actors $entity
     * @return bool
     */
    public function validation($form, Actors $entity){

        $form->handleRequest($this->request);
        if ($form->isValid()) {
            $this->processPersist($entity);
            return true;
        }

        return false;
    }

    /**
     * Remove actors
     * @param Actors $id
     */
    public function remove(Actors $id)
    {
        $form = $this->deleteForm($id);
        $form->handleRequest($this->request);

        if ($form->isValid()) {
            $this->processDelete($id);
            return true;
        }
    }

    /**
     * Creates a form to create a Actors entity.
     * @param Actors $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    public function createForm(Actors $entity)
    {
        $form = $this->formFactory->createBuilder($this->form, $entity, array(
            'action' => $this->router->generate('actors_create'),
            'method' => 'POST',
            "attr" => array('id' => "form_actor", "novalidate" => "novalidate")
        ));

        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning btn-labeled"), 'label' => 'Créer cet acteur'));

        return $form->getForm();
    }

    /**
     * Creates a form to edit a Actors entity.
     * @param Actors $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    public function editForm(Actors $entity)
    {
        $form = $this->formFactory->createBuilder($this->form, $entity, array(
            'action' => $this->router->generate('actors_update', array('id' => $entity->getId())),
            'method' => 'POST',
            "attr" => array('id' => "form_actor", "novalidate" => "novalidate")
        ));

        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning btn-labeled"), 'label' => 'Modifier cet acteur'));

        return $form->getForm();
    }


    /**
     * Creates a form to delete a Actors entity by id.
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    public function deleteForm(Actors $id)
    {
        return $this->formFactory->createBuilder()
            ->setAction($this->router->generate('actors_delete', array('id' => $id->getId())))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer', 'attr' => array('class' => 'btn btn-danger')))
            ->getForm();
    }

    /**
     * Delete a movie
     * @param Actors $entity
     */
    protected function processDelete(Actors $entity){

        $this->em->remove($entity);
        $this->em->flush();
    }


    /**
     * Persist a movie
     * @param Actors $entity
     */
    protected function processPersist(Actors $entity){

        $this->em->persist($entity);
        $this->em->flush();
    }


}