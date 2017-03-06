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
     * @Route("/carte-interactive", name="nb_graphics_front_site_interactivewebmap",
     *     defaults={
     *          "seo": true,
     *          "page": "Page Carte Interactive"
     *     }
     *  )
     */
    public function indexInteractiveWebMapAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // By default, $resultsPerFamily OR $resultsPerBird are null
        $resultsPerFamily = null;
        $resultsPerBird = null;
        $status = $em->getRepository('NBGraphicsCoreBundle:Status')->findOneByRole('VALIDED');

        // However, there are the latest results in order to display them inside the map
        

        // Search form
        $searchForm = $this->createForm(SearchFormType::class, array());

        //Criteria Maps Form
        $criteriaMapsForm = $this->createForm(CriteriaMapsFormType::class, array());

        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $data = $searchForm->getData();

            $bird = $data['oiseau'];
            $family = $data['famille'];

            // If there is no result, show message
            if (!$bird && !$family) {
                $request->getSession()->getFlashBag()->add('error', 'Merci de saisir des critères de recherche !');
                return $this->redirectToRoute('nb_graphics_front_site_interactivewebmap');
            }


            if ($bird !== null) {

                $resultsPerBird = $em->getRepository(Observation::class)->findBy(array(
                    'taxref' => $bird,
                    'status' => $status
                ));

            } elseif ($family !== null) {

                $resultsPerFamily = $em->getRepository(Observation::class)->findByFamily($family, $status);

            }

            if (!$resultsPerBird && !$resultsPerFamily) {
                $request->getSession()->getFlashBag()->add('error', 'Pas de résultats');
                return $this->redirectToRoute('nb_graphics_front_site_interactivewebmap');
            }

            if ($resultsPerBird !== null || $resultsPerFamily !== null) {

                return $this->render('@NBGraphicsFrontSite/interactiveWebMap/indexInteractiveWebMap.html.twig', [
                    'searchForm' => $searchForm->createView(),
                    'criteriaMapsForm' => $criteriaMapsForm->createView(),
                    'resultsPerBird' => $resultsPerBird,
                    'resultsPerFamily' => $resultsPerFamily,
                    'bird' => $bird,
                    'family' => $family
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
     * @Route("/carte-interactive/observation/{birdObs}")
     */
    public function displayBirdDetail($birdObs)
    {
        if (!$birdObs)
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