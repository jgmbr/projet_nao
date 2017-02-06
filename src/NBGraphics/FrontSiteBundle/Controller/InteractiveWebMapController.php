<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 10/01/2017
 * Time: 18:51
 */

namespace NBGraphics\FrontSiteBundle\Controller;

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
        $results = null;

        // Search form
        $searchForm = $this->createForm(SearchFormType::class, array());

        //Criteria Maps Form
        $criteriaMapsForm = $this->createForm(CriteriaMapsFormType::class, array());

        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $datas = $searchForm->getData();


            $bird = $datas['oiseau'];
            $family = $datas['famille'];

            dump($family);


            // Faire contrainte personnalisée à partir du formulaire
            if (!$bird && !$family) {
                $request->getSession()->getFlashBag()->add('error', 'Merci de saisir des critères de recherche !');
                return $this->redirectToRoute('nb_graphics_front_site_interactivewebmap');
            }


            $status = $em->getRepository('NBGraphicsCoreBundle:Status')->findOneByRole('VALIDED');

            // Priorité oiseau
            if ($bird !== null) {

                $results = $em->getRepository('NBGraphicsCoreBundle:Observation')->findBy(array(
                    'taxref' => $bird,
                    'status' => $status
                ));



            } elseif ($family !== null) {

                $results = $em->getRepository('NBGraphicsCoreBundle:Observation')->findByFamily($family, $status);
                

            }

            if ($results !== null) {
                dump($results);
                return $this->render('@NBGraphicsFrontSite/interactiveWebMap/indexInteractiveWebMap.html.twig', [
                    'searchForm' => $searchForm->createView(),
                    'criteriaMapsForm' => $criteriaMapsForm->createView(),
                    'results' => $results,
                ]);
            }


        }



        return $this->render('@NBGraphicsFrontSite/interactiveWebMap/indexInteractiveWebMap.html.twig', array(
            'searchForm' => $searchForm->createView(),
            'results' => $results,
        ));
    }

}