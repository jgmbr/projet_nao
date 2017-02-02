<?php

namespace NBGraphics\CoreBundle\Form;

use NBGraphics\CoreBundle\Entity\Image;
use NBGraphics\CoreBundle\Validator\Constraints\isHourTimeValid;
use NBGraphics\CoreBundle\Validator\Constraints\isThisYear;
use NBGraphics\CoreBundle\Validator\Constraints\isThisYearValid;
use NBGraphics\CoreBundle\Validator\Constraints\isThisYearValidValidator;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
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
            ->add('matureStage', ChoiceType::class, [
                'label' => "Stade de maturité de l'oiseau observé",
                'choices' => [
                    'Stade possible : jeune, premier hiver ou adulte ?' => null,
                    'Spécimen jeune' => 'Jeune',
                    'Premier hiver du spécimen' => 'Premier Hiver',
                    'Spécimen adulte' => 'adulte',
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'Vous devez choisir un stade de maturité',
                    ])
                ]
            ])
            ->add('plumage', ChoiceType::class, [
                'label' => "Quel était le plumage de l'oiseau observé ?",
                'choices' => [
                    'Plumage possible' => null,
                    'Plumage nuptial' => 'nuptial',
                    'Plumage normal' => 'normal',
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'Vous devez choisir un plumage'
                    ])
                ]
            ])
            ->add('nidification', ChoiceType::class, [
                'label' => 'Nidification',
                'choices' => [
                    'oui' => true,
                    'non' => false,
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'Vous devez renseigner la nidification ?'
                    ])
                ]
            ])
            ->add('dateAt', DateType::class, [
                'label' => "Date de l'observation : ",
                'data'  => new \DateTime(),
                //Modifier l'implémentation de la date après
                'widget' => 'choice',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez renseigner la date de l\'observation.'
                    ]),
                    new LessThanOrEqual([
                        'value' => 'today',
                        'message' => "Vous ne pouvez pas soumettre une observation ultérieure à aujourd'hui."
                    ]),
                    // Custom validators
                    new isThisYearValid([]),
                ]
            ])
            ->add('hourAt', TimeType::class, [
                'label' => "Heure de l'observation : ",
                'data'  => new \DateTime(),
                'input' => 'datetime',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez renseigner l\'horaire de l\'observation.'
                    ]),
                    //Custom validators
                    new isHourTimeValid([]),
                ]
            ])
            //Regarder pour utiliser un ClassType spécial
            ->add('image', ImageType::class, [
                'label' => "Ajouter votre photo : ",
                'required' => false,
                // Ajouter des contraintes spécifiques aux photos.
            ])
            // Coordonnées GPS :
            ->add('latitude', TextType::class, [
                'label' => 'Votre latitude',
                'required' => true
            ])
            ->add('longitude', TextType::class, [
                'label' => 'Votre longitude',
                'required' => true
            ])
            //Faire un ChoiceType avec tous les départements
            ->add('departement', ChoiceType::class, [
                'label' => 'Veuillez compléter votre département/adresse',
                'choices' => [
                    '75 Paris' => 75,
                    "95 Val d'Oise" => 95
                ]
            ])
            ->add('comment', TextareaType::class, [
                'label' => "Veuillez compléter votre observation",
                'required' => true,
                'constraints' => [
                    New NotBlank([
                        'message' => "Vous ne pouvez pas soumettre votre observation sans un message d'explication."
                    ]),
                    New Length([
                        'min' => 50,
                        'minMessage' => 'Votre observation doit comporter au moins 50 caractères.'
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
