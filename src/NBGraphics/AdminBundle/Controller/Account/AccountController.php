<?php

namespace NBGraphics\AdminBundle\Controller\Account;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccountController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();

        return $this->render('NBGraphicsAdminBundle:Account:index.html.twig',array(
            'user'                  => $user,
        ));
    }
}
