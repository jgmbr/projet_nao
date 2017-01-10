<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 10/01/2017
 * Time: 17:58
 */

namespace NBGraphics\FrontSiteBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function homePageAction()
    {
        return $this->render('@NBGraphicsFrontSite/main/homepage.html.twig');
    }

    public function researchProgramAction()
    {
        return $this->render('@NBGraphicsFrontSite/main/researchprogram.html.twig');
    }

    public function termsAction()
    {
        return $this->render('@NBGraphicsFrontSite/main/terms.html.twig');
    }

    public function creditsAction()
    {
        return $this->render('@NBGraphicsFrontSite/main/credits.html.twig');
    }
}