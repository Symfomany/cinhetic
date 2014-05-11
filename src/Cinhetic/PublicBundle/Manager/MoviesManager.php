<?php

namespace Cinhetic\PublicBundle\Manager;

use Cinhetic\PublicBundle\Entity\movies;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class MoviesManager
 * @package Cinhetic\PublicBundle\Manager
 */
class MoviesManager
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
     * Form movies
     * @var \Cinhetic\PublicBundle\Form\moviesType
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
     * @param movies $entity
     * @return bool
     */
    public function validation($form, Movies $entity){

        $form->handleRequest($this->request);

        if ($form->isValid()) {
            $this->processPersist($entity);
            return true;
        }

        return false;
    }


    /**
     * Remove movies
     * @param Movies $id
     */
    public function remove(Movies $id)
    {
        $form = $this->deleteForm($id);
        $form->handleRequest($this->request);

        if ($form->isValid()) {
            $this->processDelete($id);
            return true;
        }
    }

    /**
     * Creates a form to create a movies entity.
     * @param Movies $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    public function createForm(Movies $entity)
    {
        $form = $this->formFactory->createBuilder($this->form, $entity, array(
            'action' => $this->router->generate('movies_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning"), 'label' => 'Créer ce film'));

        return $form->getForm();
    }

    /**
     * Creates a form to edit a movies entity.
     * @param Movies $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    public function editForm(Movies $entity)
    {
        $form = $this->formFactory->createBuilder($this->form, $entity, array(
            'action' => $this->router->generate('movies_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning"), 'label' => 'Modifier ce film'));

        return $form->getForm();
    }


    /**
     * Creates a form to delete a movies entity by id.
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    public function deleteForm(Movies $id)
    {
        return $this->formFactory->createBuilder()
            ->setAction($this->router->generate('movies_delete', array('id' => $id->getId())))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Delete a movie
     * @param Movies $entity
     */
    protected function processDelete(Movies $entity){

        $this->em->remove($entity);
        $this->em->flush();
    }


    /**
     * Persist a movie
     * @param Movies $entity
     */
    protected function processPersist(Movies $entity){

        $this->em->persist($entity);
        $this->em->flush();
    }


}