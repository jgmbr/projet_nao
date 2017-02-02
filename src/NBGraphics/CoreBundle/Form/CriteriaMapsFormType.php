<?php

namespace NBGraphics\CoreBundle\Form;

use NBGraphics\CoreBundle\Entity\Observation;
use NBGraphics\CoreBundle\Form\Type\CustomButtonType;
use NBGraphics\CoreBundle\Form\Type\StepType;
use NBGraphics\CoreBundle\Repository\ObservationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CriteriaMapsFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('departement', EntityType::class, array(
                'label' => 'Par département',
                'placeholder' => 'Veuillez saisir le département',
                'class' => Observation::class,
                'choice_label' => 'departement',
                'multiple' => false,
                'query_builder' => function (ObservationRepository $repository) {
                    return $repository->findDistinctDepartementQB();
                },
                'required'      => false,
                'translation_domain' => false,
            ))
            ->add('step', StepType::class, array(
                'label' => false,
                'data' => 'OU',
                'translation_domain' => false,
            ))
            ->add('geoloc', CustomButtonType::class, array(
                'label' => false,
                'type'  => 'button',
                'name'  => 'btnGeoloc',
                'id'    => 'btnGeoloc',
                'class' => 'btn btn-info',
                'fa'    => 'map-marker',
                'title' => 'Me localiser',
                'translation_domain' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nbgraphics_corebundle_criteria_maps';
    }


}
