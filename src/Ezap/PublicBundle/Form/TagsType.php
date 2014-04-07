<?php

namespace Ezap\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TagsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('word', null, array('label' => "Mot-clef"))
            ->add('movies', null, array('label' => "Film associés"))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ezap\PublicBundle\Entity\Tags'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ezap_publicbundle_tags';
    }
}
