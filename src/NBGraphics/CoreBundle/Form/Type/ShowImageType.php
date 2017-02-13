<?php

namespace NBGraphics\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ShowImageType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['image_path']   = $options['image_path'];
        $view->vars['filter']       = $options['filter'];
        $view->vars['class']        = $options['class'];
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'image_path'    => array(),
            'filter'        => array(),
            'class'         => array()
        ));
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }
    public function getName()
    {
        return 'app_image';
    }
}