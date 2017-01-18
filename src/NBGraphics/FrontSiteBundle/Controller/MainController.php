<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 10/01/2017
 * Time: 17:58
 */

namespace NBGraphics\FrontSiteBundle\Controller;

use NBGraphics\CoreBundle\Entity\Newsletter;
use NBGraphics\CoreBundle\Form\NewsletterFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MainController extends Controller
{
    /**
     * @Route("/", name="nb_graphics_front_site_homepage")
     */
    public function homePageAction()
    {
        return $this->render('@NBGraphicsFrontSite/main/homepage.html.twig');
    }

    /**
     * @Route("/program-of-research", name="nb_graphics_front_site_researchprogramm")
     */
    public function researchProgramAction()
    {
        return $this->render('@NBGraphicsFrontSite/main/researchprogram.html.twig');
    }

    /**
     * @Route("/terms", name="nb_graphics_front_site_terms")
     */
    public function termsAction()
    {
        return $this->render('@NBGraphicsFrontSite/main/terms.html.twig');
    }

    /**
     * @Route("/credits", name="nb_graphics_front_site_credits")
     */
    public function creditsAction()
    {
        return $this->render('@NBGraphicsFrontSite/main/credits.html.twig');
    }

    /**
     * @Route("/newsletter", name="nb_graphics_front_site_newsletter")
     */
    public function newsletterAction(Request $request)
    {
        $newsletter = new Newsletter();
        $newsletterForm = $this->createForm(NewsletterFormType::class, $newsletter);
        $newsletterForm->handleRequest($request);

        if ($newsletterForm->isSubmitted() && $newsletterForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush($newsletter);
            $request->getSession()->getFlashBag()->add('success', 'Adresse email enregistrée avec succès !');
            return $this->redirectToRoute('nb_graphics_front_site_homepage');
        }

        return $this->render('@NBGraphicsFrontSite/main/newsletter.html.twig', array(
            'newsletter'       => $newsletter,
            'formNewsletter'   => $newsletterForm->createView(),
        ));
    }
}