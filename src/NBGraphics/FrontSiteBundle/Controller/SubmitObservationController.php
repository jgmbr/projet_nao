<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 10/01/2017
 * Time: 18:52
 */

namespace NBGraphics\FrontSiteBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SubmitObservationController extends Controller
{
    public function submitObservationAction()
    {
        return $this->render('@NBGraphicsFrontSite/submitObservation/formSubmitObservation.html.twig');
    }
}