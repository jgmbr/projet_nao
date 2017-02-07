<?php

namespace NBGraphics\NewsBundle\Form;

use NBGraphics\NewsBundle\Entity\State;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('state', EntityType::class, array(
                'label'                 => 'Statut de l\'article *',
                'required'              => true,
                'translation_domain'    => false,
                'class'                 => State::class,
                'choice_label'          => 'name',
                'multiple'              => false,
            ))
            ->add('title', TextType::class, array(
                'label'                 => 'Titre de l\'article *',
                'required'              => true,
                'translation_domain'    => false,
                'constraints'           => array(
                    new NotBlank(array(
                        'message' => 'Titre obligatoire'
                    )),
                    new NotNull(array(
                        'message' => 'Titre obligatoire'
                    )),
                    new Length(array(
                        'min' => 5,
                        'minMessage' => "Nombre de caractères minimum requis : 5"
                    ))
                )
            ))
            ->add('content', TextareaType::class, array(
                'label'                 => 'Contenu de l\'article *',
                'required'              => true,
                'translation_domain'    => false,
                'attr'                  => array(
                    'rows' => 10
                ),
                'constraints'           => array(
                    new NotBlank(array(
                        'message' => 'Contenu obligatoire'
                    )),
                    new NotNull(array(
                        'message' => 'Contenu obligatoire'
                    )),
                    new Length(array(
                        'min' => 25,
                        'minMessage' => "Nombre de caractères minimum requis : 25"
                    ))
                )
            ))
            ->add('image', ImageType::class, [
                'label' => "Image",
                'required' => false,
                'translation_domain' => false,
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NBGraphics\NewsBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nbgraphics_newsbundle_article';
    }


}
