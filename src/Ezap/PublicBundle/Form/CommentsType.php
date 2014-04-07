<?php

namespace Ezap\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note')
            ->add('content', null, array('label' => "Commentaire",'attr' => array('cols' => 150, 'rows' => 5)))
            ->add('movie', null, array('label' => "Films associés"))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ezap\PublicBundle\Entity\Comments'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ezap_publicbundle_comments';
    }
}
