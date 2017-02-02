<?php

namespace NBGraphics\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CustomButtonType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['type']     = $options['type'];
        $view->vars['class']    = $options['class'];
        $view->vars['fa']       = $options['fa'];
        $view->vars['name']     = $options['name'];
        $view->vars['id']       = $options['id'];
        $view->vars['title']    = $options['title'];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'type'      => array(),
            'class'     => array(),
            'fa'        => array(),
            'name'      => array(),
            'id'        => array(),
            'title'     => array(),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    public function getName()
    {
        return 'nbgraphics_step';
    }

}
