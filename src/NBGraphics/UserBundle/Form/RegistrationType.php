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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
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