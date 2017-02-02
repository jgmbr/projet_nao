<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 10/01/2017
 * Time: 18:51
 */

namespace NBGraphics\FrontSiteBundle\Controller;

use NBGraphics\CoreBundle\Form\CriteriaMapsFormType;
use NBGraphics\CoreBundle\Form\SearchFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class InteractiveWebMapController extends Controller
{
    /**
     * @Route("/webmap", name="nb_graphics_front_site_interactivewebmap")
     */
    public function indexInteractiveWebMapAction(Request $request)
    {
        // Search form

        $searchForm = $this->createForm(SearchFormType::class, array());

        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $datas = $searchForm->getData();

            var_dump($datas);
            die('check datas search form type');
        }

        // Criteria Maps

        $criteriaMapsForm = $this->createForm(CriteriaMapsFormType::class, array());

        return $this->render('@NBGraphicsFrontSite/interactiveWebMap/indexInteractiveWebMap.html.twig', array(
            'searchForm' => $searchForm->createView(),
            'criteriaMapsForm' => $criteriaMapsForm->createView()
        ));
    }
}