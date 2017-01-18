<?php

namespace NBGraphics\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/index", name="admin_page")
     */
    public function indexAction()
    {
        $user = $this->getUser();

        return $this->render('NBGraphicsAdminBundle:Common:index.html.twig',array(
            'user' => $user,
        ));
    }
}