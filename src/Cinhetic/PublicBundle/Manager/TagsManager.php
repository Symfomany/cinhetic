<?php

namespace Cinhetic\PublicBundle\Manager;

use Cinhetic\PublicBundle\Entity\tags;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class TagsManager
 * @package Cinhetic\PublicBundle\Manager
 */
class TagsManager
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
     * Form tags
     * @var \Cinhetic\PublicBundle\Form\tagsType
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
     * Create tags
     * @param Tags $entity
     * @return bool
     */
    public function validation($form, Tags $entity){

        $form->handleRequest($this->request);
        if ($form->isValid()) {
            $this->processPersist($entity);
            return true;
        }
        
        return false;
    }

    /**
     * Remove tags
     * @param Tags $id
     */
    public function remove(Tags $id)
    {
        $form = $this->deleteForm($id);
        $form->handleRequest($this->request);

        if ($form->isValid()) {
            $this->processDelete($id);
            return true;
        }
    }

    /**
     * Creates a form to create a tags entity.
     * @param Tags $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    public function createForm(Tags $entity)
    {
        $form = $this->formFactory->createBuilder($this->form, $entity, array(
            'action' => $this->router->generate('tags_create'),
            'method' => 'POST',
        ));

        return $form->getForm();
    }

    /**
     * Creates a form to edit a tags entity.
     * @param Tags $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    public function editForm(Tags $entity)
    {
        $form = $this->formFactory->createBuilder($this->form, $entity, array(
            'action' => $this->router->generate('tags_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        return $form->getForm();
    }


    /**
     * Creates a form to delete a tags entity by id.
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    public function deleteForm(Tags $id)
    {
        return $this->formFactory->createBuilder()
            ->setAction($this->router->generate('tags_delete', array('id' => $id->getId())))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer', 'attr' => array('class' => 'btn btn-danger')))
            ->getForm();
    }

    /**
     * Delete a Session
     * @param Tags $entity
     */
    protected function processDelete(Tags $entity){

        $this->em->remove($entity);
        $this->em->flush();
    }


    /**
     * Persist a Session
     * @param Tags $entity
     */
    protected function processPersist(Tags $entity){

        $this->em->persist($entity);
        $this->em->flush();
    }


}