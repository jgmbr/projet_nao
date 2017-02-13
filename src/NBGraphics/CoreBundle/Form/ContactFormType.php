<?php

namespace NBGraphics\CoreBundle\Form;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Votre prénom : ',
                'translation_domain' => false,
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 45,
                        'minMessage' => 'Veuillez entrer au moins deux lettres',
                        'maxMessage' => 'Veuillez entrer moins de 45 lettres',
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre prénom'
                    ])
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Votre nom : ',
                'translation_domain' => false,
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 120,
                        'minMessage' => 'Veuillez entrer au moins deux lettres',
                        'maxMessage' => 'Veuillez entrer moins de 120 lettres'
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre prénom'
                    ])
                ]
            ])
            ->add('emailAddress', EmailType::class, [
                'label' => 'Votre adresse e-mail : ',
                'translation_domain' => false,
                'constraints' => [
                    new Email([
                        'message' => 'Veuillez compléter un e-mail valide.'
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre adresse e-mail'
                    ]),
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message : ',
                'translation_domain' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez compléter votre message.'
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Veuillez entrer au moins de 10 caractères.'
                    ])
                ],
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'Veuillez expliquer l\'objet de votre message'
                ]
            ])
            ->add('captcha', CaptchaType::class, [
                'translation_domain' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'nbgraphics_core_bundle_contact_form_type';
    }
}
