<?php

namespace Cinhetic\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CommentsMovieType
 * @package Cinhetic\PublicBundle\Form
 */
class CommentsMovieType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note','choice', array(
                'choices'   => array('1' => 'Naz', '2' => 'Moyen', '3' => 'Agréable', "4" => "Bon film", '5' => "Excellent film"),
                'required'  => false,
            ))
            ->add('content', "textarea", array('label' => "Commentaire",'attr' => array("class" => "form-control",'cols' => 100, 'rows' => 5)))
            ->add('movie', "hidden")
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
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
