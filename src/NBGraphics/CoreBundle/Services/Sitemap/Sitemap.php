<?php

namespace NBGraphics\CoreBundle\Services\Sitemap;

use Doctrine\ORM\EntityManagerInterface;
use NBGraphics\NewsBundle\Entity\Article;
use NBGraphics\NewsBundle\Entity\State;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

class Sitemap
{
    /**
    * @var EntityManagerInterface
    */
    private $em;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(EntityManagerInterface $em, RouterInterface $router)
    {
        $this->em = $em;

        $this->router = $router;
    }

    public function generer()
    {
        $urls = array();

        // home page
        $urls[] = array(
            'loc' => $this->router->generate('nb_graphics_front_site_homepage'),
            'changefreq' => 'monthly',
            'priority' => '0.9'
        );

        $urls[] = array(
            'loc' => $this->router->generate('nb_graphics_front_site_interactivewebmap'),
            'changefreq' => 'monthly',
            'priority' => '0.8'
        );

        $urls[] = array(
            'loc' => $this->router->generate('nb_graphics_front_site_submitobservation'),
            'changefreq' => 'monthly',
            'priority' => '0.7'
        );

        $urls[] = array(
            'loc' => $this->router->generate('nb_graphics_front_site_researchprogramm'),
            'changefreq' => 'monthly',
            'priority' => '0.6'
        );

        $status = $this->em->getRepository(State::class)->findOneByRole('PUBLISH');

        $articles = $this->em->getRepository(Article::class)->findArticlesByState($status);

        $urls[] = array(
            'loc' => $this->router->generate('article_list'),
            'changefreq' => 'monthly',
            'priority' => '0.6'
        );

        foreach ($articles as $article)
        {
            $urls[] = array(
                'loc' => $this->router->generate('article_view',array('id' => $article->getId(), 'slug' => $article->getSlug())),
                'changefreq' => 'monthly',
                'priority' => '0.5'
            );
        }

        $urls[] = array(
            'loc' => $this->router->generate('nb_graphics_front_site_newsletter'),
            'changefreq' => 'monthly',
            'priority' => '0.5'
        );

        $urls[] = array(
            'loc' => $this->router->generate('nb_graphics_front_site_terms'),
            'changefreq' => 'monthly',
            'priority' => '0.5'
        );

        $urls[] = array(
            'loc' => $this->router->generate('nb_graphics_front_site_contactform'),
            'changefreq' => 'monthly',
            'priority' => '0.5'
        );

        $urls[] = array(
            'loc' => $this->router->generate('nb_graphics_front_site_credits'),
            'changefreq' => 'monthly',
            'priority' => '0.5'
        );

        $urls[] = array(
            'loc' => $this->router->generate('fos_user_security_login'),
            'changefreq' => 'monthly',
            'priority' => '0.2'
        );

        $urls[] = array(
            'loc' => $this->router->generate('fos_user_registration_register'),
            'changefreq' => 'monthly',
            'priority' => '0.2'
        );

        return $urls;

    }
}
