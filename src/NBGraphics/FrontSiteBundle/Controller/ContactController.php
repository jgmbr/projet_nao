<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 10/01/2017
 * Time: 19:53
 */

namespace NBGraphics\FrontSiteBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    public function contactFormAction()
    {
        return $this->render('@NBGraphicsFrontSite/Contact/contactForm.html.twig');
    }
}