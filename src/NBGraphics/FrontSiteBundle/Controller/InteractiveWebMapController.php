<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 10/01/2017
 * Time: 18:51
 */

namespace NBGraphics\FrontSiteBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InteractiveWebMapController extends Controller
{
    public function indexInteractiveWebMapAction()
    {
        return $this->render('@NBGraphicsFrontSite/interactiveWebMap/indexInteractiveWebMap.html.twig');
    }
}