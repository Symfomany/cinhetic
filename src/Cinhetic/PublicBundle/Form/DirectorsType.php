<?php

namespace Cinhetic\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class DirectorsType
 * @package Cinhetic\PublicBundle\Form
 */
class DirectorsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array("label" => "Nom"))
            ->add('lastname', null, array("label" => "Prénom"))
            ->add('biography', null, array("label" => "Biographie", 'attr' => array("cols" => 80, "rows" => 7)))
            ->add('note')
            ->add('movies', null, array("label" => "Films réalisés"))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinhetic\PublicBundle\Entity\Directors'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cinhetic_publicbundle_directors';
    }
}
