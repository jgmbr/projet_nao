<?php

namespace NBGraphics\SeoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SeoController extends Controller
{
    public function indexAction()
    {
        return $this->render('NBGraphicsSeoBundle:Seo:index.html.twig');
    }
}
