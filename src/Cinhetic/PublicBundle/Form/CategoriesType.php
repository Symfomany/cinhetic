<?php

namespace Cinhetic\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CategoriesType
 * @package Cinhetic\PublicBundle\Form
 */
class CategoriesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array('label' => "Titre"))
            ->add('parent', 'entity', array(
                'class' => 'CinheticPublicBundle:Categories',
                'property' => 'OptionLabel',
                'required' => false,
                'empty_value' => 'Choisissez une catégorie parente',
                'label' => 'Catégorie parente'
            ))
            ->add('description', null, array('attr' => array("class" => "ckeditor")))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinhetic\PublicBundle\Entity\Categories',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}
