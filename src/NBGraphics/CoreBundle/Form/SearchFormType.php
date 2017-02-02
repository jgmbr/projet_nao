<?php

namespace NBGraphics\CoreBundle\Form;

use NBGraphics\CoreBundle\Entity\TAXREF;
use NBGraphics\CoreBundle\Form\Type\CustomButtonType;
use NBGraphics\CoreBundle\Form\Type\StepType;
use NBGraphics\CoreBundle\Repository\TAXREFRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('famille', EntityType::class, array(
                'label' => 'Par famille d\'oiseau',
                'placeholder' => 'Veuillez saisir la famille',
                'class' => TAXREF::class,
                'choice_label' => 'famille',
                'multiple' => false,
                'query_builder' => function (TAXREFRepository $repository) {
                    return $repository->findDistinctFamilleQB();
                },
                'required' => false
            ))
            ->add('step', StepType::class, array(
                'label' => false,
                'data' => 'OU'
            ))
            ->add('oiseau', TextType::class, array(
                'label' => 'Par nom d\'oiseau',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Saisir le nom de l\'oiseau'
                )
            ))
            ->add('search', CustomButtonType::class, array(
                'label' => false,
                'type'  => 'submit',
                'name'  => 'btnSearch',
                'id'    => 'btnSearch',
                'class' => 'btn btn-primary',
                'fa'    => 'search',
                'title' => 'Rechercher un oiseau'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nbgraphics_corebundle_search';
    }


}
