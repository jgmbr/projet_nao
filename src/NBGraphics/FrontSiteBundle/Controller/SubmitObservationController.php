<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 10/01/2017
 * Time: 18:52
 */

namespace NBGraphics\FrontSiteBundle\Controller;

use NBGraphics\CoreBundle\Entity\Image;
use NBGraphics\CoreBundle\Entity\Observation;
use NBGraphics\CoreBundle\Form\ObservationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $observation = new Observation();
        $image = new Image();
        $observationForm = $this->createForm(ObservationFormType::class, $observation);
        $observationForm->handleRequest($request);

        $user = $this->getUser();

        if ($observationForm->isSubmitted() && $observationForm->isValid()) {

            $data = $observationForm->getData();

            if ($observation->getImage() !== null) {
                $image = $observation->getImage();
                $image->setObservation($observation);
                $observation->setImage($image);
                $observation->getImage()->upload();
            }

            $em = $this->getDoctrine()->getManager();

            $statut = $em->getRepository('NBGraphicsCoreBundle:Status')->findOneByRole('DEFAULT');

            $observation->setStatus($statut);

            $observation->setUser($user);
            $user->addObservation($observation);

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

    /**
     * @Route("/taxref-search-obs", name="taxref_search_obs", defaults={"_format"="json"})
     * @Method("GET")
     */
    public function searchObsTaxrefAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $term = $request->query->get('term');

        $results = $em->getRepository('NBGraphicsCoreBundle:TAXREF')->findLikeNameOrFamily($term);

        return $this->render('@NBGraphicsFrontSite/submitObservation/taxref.json.twig', array(
            'results' => $results
        ));
    }

}