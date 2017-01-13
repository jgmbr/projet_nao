<?php

namespace NBGraphics\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
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

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('enabled', ChoiceType::class, [
                    'label' => 'form.enabled',
                    'translation_domain' => 'FOSUserBundle',
                    'choices' => ['Oui' => true, 'Non' => false],
                    'expanded' => false,
                    'multiple' => false,
                ]
            )
            ->add('role', ChoiceType::class, [
                    'label' => 'form.role',
                    'translation_domain' => 'FOSUserBundle',
                    'choices' => ['Particulier' => 'ROLE_USER', 'Naturaliste' => 'ROLE_ADMIN'],
                    'expanded' => false,
                    'multiple' => false,
                ]
            )
            ->add('superAdmin', ChoiceType::class, [
                    'label' => 'form.superadmin',
                    'translation_domain' => 'FOSUserBundle',
                    'choices' => ['Oui' => true, 'Non' => false],
                    'expanded' => false,
                    'multiple' => false,
                ]
            )
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