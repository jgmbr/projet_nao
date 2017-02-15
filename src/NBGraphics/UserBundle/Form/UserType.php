<?php

namespace NBGraphics\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
                'label' => 'form.email',
                'translation_domain' => 'FOSUserBundle',
                'required' => true,
            ))
            ->add('username', null, array(
                'label' => 'form.username',
                'translation_domain' => 'FOSUserBundle',
                'required' => true,
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
                'required' => true,
            ))
            ->add('enabled', ChoiceType::class, [
                    'label' => 'form.enabled',
                    'translation_domain' => 'FOSUserBundle',
                    'choices' => array(
                        'form.yes' => true,
                        'form.no' => false
                    ),
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                ]
            )
            ->add('role', ChoiceType::class, [
                    'label' => 'form.role',
                    'translation_domain' => 'FOSUserBundle',
                    'choices' => array(
                        'form.particulier' => 'ROLE_USER',
                        'form.naturaliste' => 'ROLE_ADMIN',
                        'form.collaborateur' => 'ROLE_COLLABORATOR',
                        'form.superadmin' => 'ROLE_SUPER_ADMIN'
                    ),
                    'expanded' => false,
                    'multiple' => false,
                    'required' => true,
                ]
            )
//            ->add('superAdmin', ChoiceType::class, [
//                    'label' => 'form.superadmin',
//                    'translation_domain' => 'FOSUserBundle',
//                    'choices' => array(
//                        'form.yes' => true,
//                        'form.no' => false
//                    ),
//                    'expanded' => false,
//                    'multiple' => false,
//                    'required' => true,
//                ]
//            )
            ->add('lastname', TextType::class, array(
                'label' => 'form.lastname',
                'translation_domain' => 'FOSUserBundle',
                'required' => false,
            ))
            ->add('firstname', TextType::class, array(
                'label' => 'form.firstname',
                'translation_domain' => 'FOSUserBundle',
                'required' => false,
            ))
            ->add('phone', TextType::class, array(
                'label' => 'form.phone',
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

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            $object= $event->getData();
            $form = $event->getForm();
            if (!$object || null === $object->getId()) {
                return;
            } else {
                $form->remove('plainPassword');
            }

        });

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'NBGraphics\UserBundle\Entity\User'
        ]);
    }

}