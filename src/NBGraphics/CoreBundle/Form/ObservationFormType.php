<?php

namespace NBGraphics\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

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
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez renseigner ce champ.'
                    ]),
                    new NotNull([
                        'message' => 'Vous devez renseigner ce champ.'
                    ])
                ]
            ])
            ->add('dateAt', DateType::class, [
                'label' => "Date de l'observation : ",
                //Modifier l'implémentation de la date après
                'widget' => 'choice',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez renseigner la date de l\'observation.'
                    ]),
                    // A partir de quand peut-on renseigner une observation ?
                ]
            ])
            ->add('hourAt', TimeType::class, [
                'label' => "Heure de l'observation : ",
                'input' => 'datetime',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez renseigner l\'horaire de l\'observation.'
                    ])
                ]
            ])
            //Regarder pour utiliser un ClassType spécial
            ->add('image', FileType::class, [
                'label' => "Ajouter votre photo : "
                // Ajouter des contraintes spécifiques aux photos.
            ])
            //Faire un ChoiceType avec tous les départements
            ->add('departement', ChoiceType::class, [
                'label' => 'Veuillez compléter votre département/adresse',
                'choices' => [
                    '75 Paris' => 75,
                    "95 Val d'Oise" => 95
                ]
            ])
            // Coordonnées GPS :
            ->add('latitude', TextType::class, [
                'label' => 'Votre latitude'
            ])
            ->add('longitude', TextType::class, [
                'label' => 'Votre longitude'
            ])

            ->add('comment', TextareaType::class, [
                'label' => "Veuillez compléter votre observation",
                'constraints' => [
                    New NotBlank([
                        'message' => "Vous ne pouvez pas soumettre votre observation sans un message d'explication."
                    ]),
                    new GreaterThanOrEqual([
                        'value' => 50,
                        'message' => 'Votre observation doit au moins comprendre 50 caractères.'
                    ])
                ]
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
