<?php
/**
 * Created by PhpStorm.
 * User: Justine GAMBIER
 * Date: 12/12/2016
 * Time: 11:12
 */

namespace NBGraphics\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class, array(
                //'label' => 'form.email',
                'label' => 'Votre adresse e-mail *',
                'translation_domain' => 'FOSUserBundle',
                'required' => true,
            ))
            ->add('username', null, array(
                //'label' => 'form.username',
                'label' => 'Votre nom d\'utilisateur *',
                'translation_domain' => 'FOSUserBundle',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez compléter votre nom d\'utilisateur'
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Nombre de caractères minimum requis : 5',
                        'max' => 25,
                        'maxMessage' => 'Nombre de caractères maximum requis : 25',
                    ])
                ]
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array('translation_domain' => 'FOSUserBundle'),
                //'first_options' => array('label' => 'form.password'),
                'first_options' => array('label' => 'Votre mot de passe *'),
                //'second_options' => array('label' => 'form.password_confirmation'),
                'second_options' => array('label' => 'Confirmer votre mot de passe *'),
                'invalid_message' => 'fos_user.password.mismatch',
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit faire au moins 8 caractères',
                        'max' => 255,
                        'maxMessage' => 'Votre mot de passe est trop long',
                    ])
                ]
            ))
            ->add('firstname', TextType::class, array(
                //'label' => 'form.firstname',
                'label' => 'Votre prénom *',
                'translation_domain' => 'FOSUserBundle',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez compléter votre prénom'
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Nous avons besoin d\'un prénom de minimum 3 caractères.',
                        'max' => 100,
                        'maxMessage' => 'Nous avons besoin d\'un prénom de maximum 100 caractères.',
                    ])
                ]
            ))
            ->add('lastname', TextType::class, array(
                //'label' => 'form.lastname',
                'label' => 'Votre nom *',
                'translation_domain' => 'FOSUserBundle',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez compléter votre nom de famille'
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Nous avons besoin d\'un nom de minimum 3 caractères.',
                        'max' => 100,
                        'maxMessage' => 'Nous avons besoin d\'un nom de maximum 100 caractères.',
                    ])
                ]
            ))
            ->add('phone', TextType::class, array(
                //'label' => 'form.phone',
                'label' => 'Votre numéro de mobile',
                'translation_domain' => 'FOSUserBundle',
                'required' => false,
                'constraints' => array(
                    new Length(array(
                        'min' => 10,
                        'minMessage' => 'Nombre de caractères minimal requis 10',
                        'max' => 10,
                        'maxMessage' => 'Nombre de caractères maximal requis 10',
                    )),
                    new Regex(array(
                        'pattern' => '^0[0-9]([-. ]?\d{2}){4}[-. ]?$^',
                        'message' => 'Format numéro de mobile incorrect'
                    ))
                )
            ))
            ->add('enableCampaigns', CheckboxType::class, array(
                'label' => 'form.enableCampaigns',
                'translation_domain' => 'FOSUserBundle',
                'required' => false,
            ))
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}