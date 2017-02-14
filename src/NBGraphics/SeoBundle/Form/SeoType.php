<?php

namespace NBGraphics\SeoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class SeoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('page', TextType::class, array(
                'label'                 => 'Page *',
                'required'              => true,
                'translation_domain'    => false,
                'attr' => array(
                    'readonly' => true
                )
            ))
            ->add('route', TextType::class, array(
                'label'                 => 'Route *',
                'required'              => true,
                'translation_domain'    => false,
                'attr' => array(
                    'readonly' => true
                )
            ))
            ->add('title', TextType::class, array(
                'label'                 => 'Titre *',
                'required'              => false,
                'translation_domain'    => false,
                'constraints'           => array(
                    new Length(array(
                        'min' => 5,
                        'minMessage' => "Nombre de caractères minimum requis : 5",
                        'max' => 255,
                        'maxMessage' => "Nombre de caractères maximum requis : 255"
                    ))
                )
            ))
            ->add('metaDescription', TextareaType::class, array(
                'label'                 => 'Description *',
                'required'              => false,
                'translation_domain'    => false,
                'constraints'           => array(
                    new Length(array(
                        'min' => 5,
                        'minMessage' => "Nombre de caractères minimum requis : 5",
                    ))
                )
            ))
            ->add('metaKeywords', TextareaType::class, array(
                'label'                 => 'Mots clés *',
                'required'              => false,
                'translation_domain'    => false,
                'constraints'           => array(
                    new Length(array(
                        'min' => 5,
                        'minMessage' => "Nombre de caractères minimum requis : 5",
                    ))
                )
            ))
            ->add('metaRobots', ChoiceType::class, array(
                'label'                 => 'Robots *',
                'required'              => false,
                'translation_domain'    => false,
                'choices'           => array(
                    'noindex' => 'noindex',
                    'nofollow' => 'nofollow',
                    'index' => 'index',
                    'follow' => 'follow',
                    'all' => 'all',
                    'none' => 'none',
                    'nosnippet' => 'nosnippet',
                    'noarchive' => 'noarchive',
                    'nocache' => 'nocache',
                    'noodp' => 'noodp'
                )
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NBGraphics\SeoBundle\Entity\Seo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nbgraphics_seobundle_seo';
    }


}
