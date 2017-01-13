<?php

namespace NBGraphics\AdminBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/index", name="admin_page")
     */
    public function indexAction()
    {
        $user               = $this->getUser();

        return $this->render('NBGraphicsAdminBundle:Admin:index.html.twig',array(
            'user'              => $user,
        ));
    }
}