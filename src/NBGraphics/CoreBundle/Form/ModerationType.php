<?php

namespace NBGraphics\CoreBundle\Form;

use NBGraphics\CoreBundle\Entity\Status;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ModerationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', EntityType::class, array(
                'label'         => 'Statut *',
                'required'      => true,
                'translation_domain' => false,
                'class'         => Status::class,
                'choice_label'  => 'name',
                'multiple'      => false,
            ))
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire *',
                'required' => true,
                'constraints' => [
                    New NotBlank([
                        'message' => "Vous ne pouvez pas soumettre la modération sans renseigner un commentaire valide."
                    ]),
                    New Length([
                        'min' => 10,
                        'minMessage' => 'Votre commentaire doit comporter au moins 10 caractères.'
                    ])
                ],
                'attr' => [
                    'rows' => 5
                ],
                'translation_domain' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'NBGraphics\CoreBundle\Entity\Moderation'
        ]);
    }
}
