<?php

namespace Ezap\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SessionsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateSession')
            ->add('movies', null, array('label' => "Films associés"))
            ->add('cinema', null, array('label' => "Cinéma associé"))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ezap\PublicBundle\Entity\Sessions'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ezap_publicbundle_sessions';
    }
}
