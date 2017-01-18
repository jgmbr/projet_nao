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

        $user = $this->getUser();

        if ($observationForm->isSubmitted() && $observationForm->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $statut = $em->getRepository('NBGraphicsCoreBundle:Status')->findOneByRole('DEFAULT');

            $observation->setStatus($statut);

            $observation->setUser($user);
            $user->addObservation($observation);

            $em->persist($observation);
            $em->flush($observation);

            $request->getSession()->getFlashBag()->add('success', 'Observation ajoutée avec succès !');
            return $this->redirectToRoute('account_observation');

        }

        return $this->render('@NBGraphicsFrontSite/submitObservation/formSubmitObservation.html.twig', array(
            'observation'       => $observation,
            'observationForm'   => $observationForm->createView(),
        ));
    }
}