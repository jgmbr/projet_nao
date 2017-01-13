<?php

namespace NBGraphics\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', ChoiceType::class, [
                'label' => "Nombre d'oiseaux aperçu",
                'choices' => [
                    'Avez-vous aperçu un individu, un groupe ou un couple' => null,
                    'Un individu' => 'individu',
                    'Un couple' => 'couple',
                    'Un groupe' => 'groupe'
                ]
            ])
            ->add('dateAt', DateType::class, [
                'label' => "Date de l'observation : ",
                //Modifier l'implémentation de la date après
                'widget' => 'choice',
            ])
            ->add('hourAt', TimeType::class, [
                'label' => "Heure de l'observation : ",
                'input' => 'datetime'
            ])
            //Regarder pour utiliser un ClassType spécial
            ->add('image', FileType::class, [
                'label' => "Ajouter votre photo : "
            ])
            //Faire un ChoiceType avec tous les départements
            ->add('departement', ChoiceType::class, [
                'label' => 'Veuillez compléter votre département/adresse',
                'choices' => [
                    '75 Paris' => '75',
                    "95 Val d'Oise" => '95'
                ]
            ])

            ->add('comment', TextareaType::class, [
                'label' => "Veuillez compléter votre observation"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => "NBGraphics\CoreBundle\Entity\Observation"
        ]);
    }

    public function getName()
    {
        return 'nbgraphics_core_bundle_observation_form_type';
    }
}
