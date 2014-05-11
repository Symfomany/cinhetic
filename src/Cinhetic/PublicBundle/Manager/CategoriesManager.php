<?php

namespace Cinhetic\PublicBundle\Manager;

use Cinhetic\PublicBundle\Entity\Categories;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class CategoriesManager
 * @package Cinhetic\PublicBundle\Manager
 */
class CategoriesManager
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
     * Form categories
     * @var \Cinhetic\PublicBundle\Form\categoriesType
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
     * Create categories
     * @param categories $entity
     * @return bool
     */
    public function validation($form, Categories $entity){

        $form->handleRequest($this->request);
        if ($form->isValid()) {
            $this->processPersist($entity);
            return true;
        }

        return false;
    }

    /**
     * Remove categories
     * @param categories $id
     */
    public function remove(Categories $id)
    {
        $form = $this->deleteForm($id);
        $form->handleRequest($this->request);

        if ($form->isValid()) {
            $this->processDelete($id);
            return true;
        }
    }

    /**
     * Creates a form to create a categories entity.
     * @param categories $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    public function createForm(Categories $entity)
    {
        $form = $this->formFactory->createBuilder($this->form, $entity, array(
            'action' => $this->router->generate('categories_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning"), 'label' => 'Créer cette catégorie'));

        return $form->getForm();
    }

    /**
     * Creates a form to edit a categories entity.
     * @param categories $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    public function editForm(Categories $entity)
    {
        $form = $this->formFactory->createBuilder($this->form, $entity, array(
            'action' => $this->router->generate('categories_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array("attr" => array('class' => "btn btn-warning"), 'label' => 'Modifier cette catégorie'));

        return $form->getForm();
    }


    /**
     * Creates a form to delete a categories entity by id.
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    public function deleteForm(categories $id)
    {
        return $this->formFactory->createBuilder()
            ->setAction($this->router->generate('categories_delete', array('id' => $id->getId())))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Delete a movie
     * @param categories $entity
     */
    protected function processDelete(Categories $entity){

        $this->em->remove($entity);
        $this->em->flush();
    }


    /**
     * Persist a movie
     * @param categories $entity
     */
    protected function processPersist(Categories $entity){

        $this->em->persist($entity);
        $this->em->flush();
    }


}