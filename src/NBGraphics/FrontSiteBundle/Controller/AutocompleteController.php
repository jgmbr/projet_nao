<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 10/01/2017
 * Time: 19:53
 */

namespace NBGraphics\FrontSiteBundle\Controller;

use NBGraphics\CoreBundle\Entity\TAXREF;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AutocompleteController extends Controller
{
    /**
     * @Route("/taxref-search", name="taxref_search", defaults={"_format"="json"})
     * @Method("GET")
     */
    public function searchTaxrefAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $term = $request->query->get('term');

        $results = $em->getRepository(TAXREF::class)->findLikeNameOrFamily($term);

        return $this->render('@NBGraphicsFrontSite/json/taxref.json.twig', array(
            'results' => $results
        ));
    }

    /**
     * @Route("/taxref-get/{id}", name="taxref_get", defaults={"_format"="json"})
     * @Method("GET")
     */
    public function getAction($id = null){

        $em = $this->getDoctrine()->getManager();

        if (is_null($taxref = $em->getRepository(TAXREF::class)->find($id))) {
            throw $this->createNotFoundException();
        }

        return $this->json($taxref->getNomComplet());
    }

}