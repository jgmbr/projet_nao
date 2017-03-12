<?php

namespace NBGraphics\FrontSiteBundle\Controller;

use NBGraphics\CoreBundle\Entity\Newsletter;
use NBGraphics\CoreBundle\Form\NewsletterFormType;
use NBGraphics\SeoBundle\Entity\Seo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LandingController extends Controller
{
    /**
     * @Route("/observation-des-oiseaux",
     *     name="nb_graphics_front_site_landing_a",
     *     defaults={
     *          "seo": true,
     *          "page": "Page Landing Observation des Oiseaux"
     *     }
     *  )
     */
    public function landingAPageAction()
    {
        return $this->render('@NBGraphicsFrontSite/landing/a.html.twig');
    }

    /**
     * @Route("/observer-des-oiseaux",
     *     name="nb_graphics_front_site_landing_b",
     *     defaults={
     *          "seo": true,
     *          "page": "Page Landing Observer des Oiseaux"
     *     }
     *  )
     */
    public function landingBPageAction()
    {
        return $this->render('@NBGraphicsFrontSite/landing/b.html.twig');
    }
}