<?php

namespace Cinhetic\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ActorsType
 * @package Cinhetic\PublicBundle\Form
 */
class ActorsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array("label" => "Prénom",'attr' => array("class" => "form-control")))
            ->add('lastname', null, array("label" => "Nom",'attr' => array("class" => "form-control")))
            ->add('dob', null, array("label" => "Date de naissance"))
            ->add('city', null, array("label" => "Ville d'origine"))
            ->add('nationality', "language", array("label" => "Nationalité"))
            ->add('biography', null, array("label" => "Biographie", 'attr' => array("cols" => 80, "rows" => 7,"class" => "ckeditor")))
            ->add('roles', null, array('attr' => array("class" => "ckeditor")))
            ->add('recompenses', null, array('attr' => array("class" => "ckeditor")))
            ->add('movies', null, array("label" => "Films associés"))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinhetic\PublicBundle\Entity\Actors'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Cinhetic_publicbundle_actors';
    }
}
