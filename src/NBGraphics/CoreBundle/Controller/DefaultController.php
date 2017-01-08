<?php

namespace NBGraphics\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NBGraphicsCoreBundle:Default:index.html.twig');
    }
}
