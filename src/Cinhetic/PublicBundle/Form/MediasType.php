<?php

namespace Cinhetic\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class MediasType
 * @package Cinhetic\PublicBundle\Form
 */
class MediasType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('video', null, array('label' => "Url de la vidéo", 'attr' => array("placeholder" => "https://www.youtube.com/watch?v=xI1YNW757cQ")));
    }
    
    /**
     * Set defaults options
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinhetic\PublicBundle\Entity\Medias',
        ));
    }

    /**
     * Get name of form
     * @return string
     */
    public function getName()
    {
        return '';
    }
}
