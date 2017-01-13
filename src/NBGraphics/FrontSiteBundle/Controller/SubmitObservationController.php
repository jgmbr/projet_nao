<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 10/01/2017
 * Time: 18:52
 */

namespace NBGraphics\FrontSiteBundle\Controller;


use NBGraphics\CoreBundle\Entity\Observation;
use NBGraphics\CoreBundle\Form\ObservationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SubmitObservationController extends Controller
{
    public function submitObservationAction(Request $request)
    {
        $observation = new Observation();
        $observationForm = $this->createForm(ObservationFormType::class, $observation);


        $observationForm->handleRequest($request);
        if ($observationForm->isSubmitted() && $observationForm->isValid()) {
            $observation = $observationForm->getData();




        }

        return $this->render('@NBGraphicsFrontSite/submitObservation/formSubmitObservation.html.twig', [
            'observationForm' => $observationForm->createView(),
        ]);
    }
}