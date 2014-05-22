<?php

namespace Cinhetic\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class MoviesType
 * @package Cinhetic\PublicBundle\Form
 */
class MoviesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array('label' => "Titre"))
            ->add('typeFilm',  'choice', array(
                'label' => "Type de film",
                'choices'   => array(
                    'Long-Metrage' => 'Long Metrage',
                    'Moyen-Metrage' => 'Moyen Metrage',
                    'Court-Metrage' => 'Court Metrage'
                ),
                'required'  => true,
            ))
            ->add('synopsis', null, array('attr' => array("class" => "ckeditor")))
            ->add('description', null, array('attr' => array("class" => "ckeditor")))
            ->add('file', null, array("label" => "Image à mettre en avant",'attr' => array('accept', "image/*", "capture" => "capture")))
            ->add('files', "file", array('mapped' => false))
            ->add('trailer', null, array('attr' => array("class" => "form-control", "cols" => 80, "rows" => 7)))
            ->add('languages', "language")
            ->add('distributeur', 'choice', array(
                'label' => "Maison de production",
                'choices'   => array(
                    'Warner_Bros' => 'Warner Bros',
                    'Paramont' => 'Paramont',
                    'HBO' => 'HBO',
                    'TwentiethCenturyFox' => 'TwentiethCenturyFox',
                    'UniversalPicturesGroup' => 'UniversalPicturesGroup',
                    'ColumbiaPictures' => 'ColumbiaPictures',
                    'WaltDisney' => 'WaltDisney',
                    'MarvelEntertainment ' => 'MarvelEntertainment',
                    'Lucasfilm ' => 'Lucasfilm'
                ),
                'required'  => true,
            ))
            ->add('bo', 'choice', array(
                'label' => "Bande Original",
                'choices'   => array('VO' => 'VO', 'VOST' => 'VOST','VOFR' => 'VOFR'),
                'required'  => true,
            ))
            ->add('annee')
            ->add('budget')
            ->add('duree')
            ->add('dateRelease', 'datetime',
                array(
                    'attr' => array('class' => 'datepick form-control', "placeholder" => "Format: YYYY-mm-dd"),
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'label' => "Date de sortie"
                ))
            ->add('notePresse','choice', array(
                'choices'   => array(
                    '1' => 'Naz',
                    '2' => 'Moyen',
                    "3" => "Passable",
                    "4" => "Bon film",
                    '5' => "Un chef-d'oeuvre!"),
                'required'  => false,
            ))
            ->add('visible', null, array('attr' => array('class' => "px")))
            ->add('shop', null, array('attr' => array('class' => "px")))
            ->add('shopMode','choice', array(
                'label' => "Type de vente",
                'choices'   => array(
                    '1' => 'Disponible à la vente',
                    '2' => 'Afficher le prix',
                    "3" => "Bientôt en vente",
                    "4" => "Disponible en point de vente",
                    '5' => "Indisponible"),
            ))
            ->add('shopTypeDvd','choice', array(
                'label' => "Type de format",
                'choices'   => array(
                    '1' => 'DVD',
                    '2' => 'Blue-Ray',
                    "3" => "Blue-Ray 3D",
            )))
            ->add('taxe','choice', array(
                'label' => "Taxe",
                'choices'   => array(
                    '1' => '20%',
                    '2' => '10%',
                    '3' => '7%',
                    "4" => "5%",
            )))
            ->add('shopDate', 'datetime',
                array(
                'attr' => array('class' => 'datepick form-control', "placeholder" => "Format: YYYY-mm-dd"),
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'label' => "Date de sortie du DVD"
            ))
            ->add('quantity', null, array('label' => "Quantité", "attr" => array("placeholder" => "17")))
            ->add('price', null, array('label' => "Prix", "attr" => array("placeholder" => "Format: 00.00")))
            ->add('ref', null, array(  'label' => "Référence", "attr" => array("placeholder" => "AA-XXXX-BB")))
            ->add('cover', null, array('attr' => array('class' => "px")))
            ->add('category', null, array('required' => true, 'property' => 'optionLabel'))
            ->add('actors', null, array('label' => "Acteurs qui ont joué dans ce film"))
            ->add('cinemas', null, array('label' => "Cinéma qui le diffusent"))
            ->add('directors', null, array('required' => true,'label' => "Réalisateur"))
            ->add('moviesRelated', null, array('label' => "Film associé"))
            ->add('tags', null, array('label' => "Tags associé"))
            ->add('medias', 'collection', array(
                'type' => new MediasType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ));

        ;
    }
    
    /**
     * Set defaults options
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinhetic\PublicBundle\Entity\Movies',
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
