<?php

namespace Cinhetic\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SessionsType
 * @package Cinhetic\PublicBundle\Form
 */
class SessionsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateSession', 'datetime',
                array(
                    'attr' => array('class' => 'form-control datepick'),
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'label' => "Date de la séance"
                ))
             ->add('hourSession', 'text',
                array(
                    'mapped' => false,
                    'label' => "Heure de la séance",
                    'attr' => array('class' => 'hour form-control'),
                ))
            ->add('movies', null, array('required' => "required",'label' => "Films associés"))
            ->add('cinema', null, array('required' => "required",'label' => "Cinéma associé"))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinhetic\PublicBundle\Entity\Sessions'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Cinhetic_publicbundle_sessions';
    }
}
