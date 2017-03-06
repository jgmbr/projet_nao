<?php

namespace NBGraphics\CoreBundle\Form;

use NBGraphics\CoreBundle\Entity\Image;
use NBGraphics\CoreBundle\Entity\TAXREF;
use NBGraphics\CoreBundle\Form\Type\HelpType;
use NBGraphics\CoreBundle\Form\Type\ShowImageType;
use NBGraphics\CoreBundle\Validator\Constraints\isHourTimeValid;
use NBGraphics\CoreBundle\Validator\Constraints\isThisYear;
use NBGraphics\CoreBundle\Validator\Constraints\isThisYearValid;
use NBGraphics\CoreBundle\Validator\Constraints\isThisYearValidValidator;
use PUGX\AutocompleterBundle\Form\Type\AutocompleteType;
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
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ObservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('taxref', AutocompleteType::class, array(
                'label' => 'Espèce - Nom d\'oiseau *',
                'class' => TAXREF::class,
                'required'      => true,
                'translation_domain' => false,
                'attr' => array(
                    'placeholder' => 'Nom de l\'espèce ou de l\'oiseau'
                )
            ))
            ->add('quantity', ChoiceType::class, [
                'label' => "Nombre d'oiseaux aperçus *",
                'choices' => [
                    'Nombre d\'oiseaux aperçus' => null,
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
                ],
                'required'      => true,
                'translation_domain' => false,
            ])
            ->add('matureStage', ChoiceType::class, [
                'label' => "Stade de maturité de l'oiseau observé *",
                'choices' => [
                    'Jeune, premier hiver ou adulte ?' => null,
                    'Spécimen juvénile' => 'juvenile',
                    'Premier hiver du spécimen' => 'premier_hiver',
                    'Spécimen adulte' => 'adulte',
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'Vous devez choisir un stade de maturité',
                    ])
                ],
                'required'      => true,
                'translation_domain' => false,
            ])
            ->add('plumage', ChoiceType::class, [
                'label' => "Quel était le plumage de l'oiseau observé ? *",
                'choices' => [
                    'Plumage possible' => null,
                    'Plumage nuptial' => 'nuptial',
                    'Plumage normal' => 'normal',
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'Vous devez choisir un plumage'
                    ])
                ],
                'required'      => true,
                'translation_domain' => false,
            ])
            ->add('nidification', ChoiceType::class, [
                'label' => 'Nidification *',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'Vous devez renseigner la nidification ?'
                    ])
                ],
                'required'      => true,
                'translation_domain' => false,
            ])
            ->add('dateAt', DateType::class, [
                'label' => "Date de l'observation *",
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
                ],
                'required'      => true,
                'translation_domain' => false,
            ])
            ->add('hourAt', TimeType::class, [
                'label' => "Heure de l'observation *",
                'input' => 'datetime',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez renseigner l\'horaire de l\'observation.'
                    ]),
                    new isHourTimeValid([]),
                ],
                'required'      => true,
                'translation_domain' => false,
            ])
            ->add('image', ImageType::class, [
                'label' => "Ajouter votre photo",
                'required' => false,
                'translation_domain' => false,
            ])
            ->add('latitude', TextType::class, [
                'label' => 'Votre latitude *',
                'required' => true,
                'attr' => [
                  'placeholder' => '48.856614'
                ],
                'translation_domain' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de vous géolocaliser'
                    ]),
                    new NotNull([
                        'message' => 'Merci de vous géolocaliser'
                    ])
                ]
            ])
            ->add('longitude', TextType::class, [
                'label' => 'Votre longitude *',
                'required' => true,
                'attr' => [
                    'placeholder' => '2.3522219'
                ],
                'translation_domain' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de vous géolocaliser'
                    ]),
                    new NotNull([
                        'message' => 'Merci de vous géolocaliser'
                    ])
                ]
            ])
            ->add('departement', TextType::class, [
                'label' => 'Département *',
                'translation_domain' => false,
                'constraints' => [
                    new NotNull([
                        'message' => 'Merci de vous géolocaliser'
                    ]),
                    new NotBlank([
                        'message' => 'Merci de vous géolocaliser'
                    ])
                ]
            ])
            ->add('comment', TextareaType::class, [
                'label' => "Veuillez compléter votre observation * (50 caractères minimum)",
                'required' => true,
                'constraints' => [
                    New NotBlank([
                        'message' => "Vous ne pouvez pas soumettre votre observation sans un message d'explication."
                    ]),
                    New Length([
                        'min' => 50,
                        'minMessage' => 'Votre observation doit comporter au moins 50 caractères.'
                    ])
                ],
                'translation_domain' => false,
                'attr' => array(
                    'rows' => 10,
                    'placeholder' => 'Sans commentaire de votre part, l\'observation ne pourra être envoyée et soumise à la modération des Naturalistes'
                )
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            $object = $event->getData();
            $form = $event->getForm();
            if (!$object || null === $object->getId()) {
                return;
            } else {
                // Check if has image
                if ($object->getImage()) {
                    $form->add('tmpImage', ShowImageType::class, array(
                        'label'         => 'Image Originale',
                        'required'      => false,
                        'translation_domain' => false,
                        'image_path'    => $object->getImage()->getWebPath(),
                        'filter'        => 'avatar',
                        'class'         => 'img-responsive img-circle'
                    ));
                }
            }
        });
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
