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
     * @Route("/submit-observation", name="nb_graphics_front_site_submitobservation")
     */
    public function submitObservationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $observation = new Observation();
        $observationForm = $this->createForm(ObservationFormType::class, $observation);
        $observationForm->handleRequest($request);

        $user = $this->getUser();

        if ($observationForm->isSubmitted() && $observationForm->isValid()) {

            if ($observation->getImage() !== null) {
                $image = $observation->getImage();
                $image->setObservation($observation);
                $observation->setImage($image);
                $observation->getImage()->upload();
            }

            // Validation automatique de l'observation
            if ($user->hasRole('ROLE_ADMIN') || $user->hasRole('ROLE_SUPER_ADMIN')) {

                $statut = $em->getRepository('NBGraphicsCoreBundle:Status')->findOneByRole('VALIDED');
                $observation->setStatus($statut);
                $observation->setUser($user);
                $user->addObservation($observation);
                $moderation = new Moderation();
                $moderation->setComment('Validation automatique');
                $moderation->setObservation($observation);
                $moderation->setStatus($statut);

            // Observation en attente
            } else {

                $statut = $em->getRepository('NBGraphicsCoreBundle:Status')->findOneByRole('DEFAULT');
                $observation->setStatus($statut);
                $observation->setUser($user);
                $user->addObservation($observation);
                $moderation = new Moderation();
                $moderation->setComment('En attente de validation par un modérateur');
                $moderation->setObservation($observation);
                $moderation->setStatus($statut);

            }

            $em->persist($moderation);
            $em->persist($observation);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Observation ajoutée avec succès !');
            return $this->redirectToRoute('nb_graphics_user_homepage');

        }

        return $this->render('@NBGraphicsFrontSite/submitObservation/formSubmitObservation.html.twig', array(
            'observation'       => $observation,
            'observationForm'   => $observationForm->createView(),
        ));
    }

}