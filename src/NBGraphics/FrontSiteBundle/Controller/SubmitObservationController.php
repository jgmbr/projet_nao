<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 10/01/2017
 * Time: 18:52
 */

namespace NBGraphics\FrontSiteBundle\Controller;

use NBGraphics\CoreBundle\Entity\Image;
use NBGraphics\CoreBundle\Entity\Moderation;
use NBGraphics\CoreBundle\Entity\Observation;
use NBGraphics\CoreBundle\Form\ObservationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SubmitObservationController extends Controller
{
    /**
     * @Route("/soumettre-une-observation", name="nb_graphics_front_site_submitobservation",
     *     defaults={
     *          "seo": true,
     *          "page": "Page Soumettre une observation"
     *     }
     *  )
     */
    public function submitObservationAction(Request $request)
    {
        if ($this->getUser()->hasRole('ROLE_COLLABORATOR')) {
            throw $this->createNotFoundException("Soumission observation non autorisée");
        }

        $observation = new Observation();
        $observationForm = $this->createForm(ObservationFormType::class, $observation);
        $observationForm->handleRequest($request);

        $user = $this->getUser();

        if ($observationForm->isSubmitted() && $observationForm->isValid()) {

            $createObservation = $this->get('app.crud.create')->createObservation($observation, $user);

            if ($createObservation) {
                $this->addFlash('success', 'Observation ajoutée avec succès !');
                return $this->redirectToRoute('admin_page');
            } else {
                $this->addFlash('error', 'Erreur lors de la soumission de l\'observation');
                return $this->redirectToRoute('nb_graphics_front_site_submitobservation');
            }

        }

        return $this->render('@NBGraphicsFrontSite/submitObservation/formSubmitObservation.html.twig', array(
            'observation'       => $observation,
            'observationForm'   => $observationForm->createView(),
        ));
    }

}