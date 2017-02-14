<?php

namespace NBGraphics\SeoBundle\Controller;

use NBGraphics\SeoBundle\Entity\Seo;
use NBGraphics\SeoBundle\Form\SeoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Newsletter controller.
 *
 * @Route("admin/seo")
 */
class SeoController extends Controller
{
    /**
     * Lists all seo entities.
     *
     * @Route("/", name="seo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pagesSeo = $em->getRepository(Seo::class)->findAll();

        return $this->render('NBGraphicsSeoBundle:Seo:index.html.twig', array(
            'pagesSeo' => $pagesSeo
        ));
    }

    /**
     * Displays a form to edit an existing seo entity.
     *
     * @Route("/edition/{id}", name="seo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Seo $seo)
    {
        $editForm = $this->createForm(SeoType::class, $seo);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'SEO modifié avec succès !');

            return $this->redirectToRoute('seo_show', array('id' => $seo->getId()));

        }

        return $this->render('NBGraphicsSeoBundle:Seo:edit.html.twig', array(
            'seo' => $seo,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Finds and displays a seo entity.
     *
     * @Route("/fiche/{id}", name="seo_show")
     * @Method("GET")
     */
    public function showAction(Seo $seo)
    {
        return $this->render('NBGraphicsSeoBundle:Seo:show.html.twig', array(
            'seo' => $seo
        ));
    }

    public function menuAction(Request $request, $active)
    {
        return $this->render('NBGraphicsSeoBundle:Seo:menu.html.twig', array(
            'active' => ($active ? 'active' : '')
        ));
    }
}
