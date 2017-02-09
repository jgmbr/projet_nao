<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 10/01/2017
 * Time: 18:51
 */

namespace NBGraphics\FrontSiteBundle\Controller;

use NBGraphics\CoreBundle\Entity\Observation;
use NBGraphics\CoreBundle\Entity\TAXREF;
use NBGraphics\CoreBundle\Form\CriteriaMapsFormType;
use NBGraphics\CoreBundle\Form\SearchFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InteractiveWebMapController extends Controller
{
    /**
     * @Route("/webmap", name="nb_graphics_front_site_interactivewebmap")
     */
    public function indexInteractiveWebMapAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // By default, $results is null
        $resultsPerFamily = null;
        $resultsPerBird = null;

        // Search form
        $searchForm = $this->createForm(SearchFormType::class, array());

        //Criteria Maps Form
        $criteriaMapsForm = $this->createForm(CriteriaMapsFormType::class, array());

        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $data = $searchForm->getData();

            $bird = $data['oiseau'];
            $family = $data['famille'];

            // Faire contrainte personnalisée à partir du formulaire
            if (!$bird && !$family) {
                $request->getSession()->getFlashBag()->add('error', 'Merci de saisir des critères de recherche !');
                return $this->redirectToRoute('nb_graphics_front_site_interactivewebmap');
            }

            $status = $em->getRepository('NBGraphicsCoreBundle:Status')->findOneByRole('VALIDED');

            if ($bird !== null) {

                $resultsPerBird = $em->getRepository(Observation::class)->findBy(array(
                    'taxref' => $bird,
                    'status' => $status
                ));

            } elseif ($family !== null) {

                $resultsPerFamily = $em->getRepository(Observation::class)->findByFamily($family, $status);

            }

            if ($resultsPerBird !== null || $resultsPerFamily !== null) {

                return $this->render('@NBGraphicsFrontSite/interactiveWebMap/indexInteractiveWebMap.html.twig', [
                    'searchForm' => $searchForm->createView(),
                    'criteriaMapsForm' => $criteriaMapsForm->createView(),
                    'resultsPerBird' => $resultsPerBird,
                    'resultsPerFamily' => $resultsPerFamily,
                ]);
            }
        }

        return $this->render('@NBGraphicsFrontSite/interactiveWebMap/indexInteractiveWebMap.html.twig', array(
            'searchForm' => $searchForm->createView(),
            'resultsPerBird' => $resultsPerBird,
            'resultsPerFamily' => $resultsPerFamily,
        ));
    }

    /**
     * @Route("/webmap/{birdObs}")
     */
    public function displayBirdDetail($birdObs)
    {
        if (!$birdObs || !is_int($birdObs))
            throw $this->createNotFoundException("Aucun oiseau trouvé à l'id " . $birdObs . " !");

        $em = $this->getDoctrine()->getManager();

        $bird = $em->getRepository(Observation::class)->findOneBy([
            'id' => $birdObs,
        ]);

        if (!is_object($bird))
            throw $this->createNotFoundException("Aucun oiseau trouvé à l'id " . $birdObs . " !");

        return $this->render('@NBGraphicsFrontSite/interactiveWebMap/displayBird.html.twig', [
            'bird' => $bird,
        ]);
    }

}