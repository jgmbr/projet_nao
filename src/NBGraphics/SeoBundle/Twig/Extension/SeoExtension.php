<?php

namespace NBGraphics\SeoBundle\Twig\Extension;

use NBGraphics\SeoBundle\Entity\Seo;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SeoExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    private $doctrine;

    public function __construct(ContainerInterface $container)
    {
        $this->doctrine = $container->get('doctrine');
    }

    /**
     * Return the functions registered as twig extensions
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'getSEO' => new \Twig_Function_Method($this, 'getSEO'),
        );
    }

    public function getSEO($route)
    {
        return ($this->doctrine->getRepository(Seo::class)->findOneByRoute($route) ? $this->doctrine->getRepository(Seo::class)->findOneByRoute($route) : '');
    }

}
