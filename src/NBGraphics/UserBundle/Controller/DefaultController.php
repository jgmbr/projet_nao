<?php

namespace NBGraphics\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NBGraphicsUserBundle:Default:index.html.twig');
    }
}
