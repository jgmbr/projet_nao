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
use NBGraphics\SeoBundle\Entity\Seo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MainController extends Controller
{
    /**
     * @Route("/",
     *     name="nb_graphics_front_site_homepage",
     *     defaults={
     *          "seo": true,
     *          "page": "Page Accueil"
     *     }
     *  )
     */
    public function homePageAction()
    {
        return $this->render('@NBGraphicsFrontSite/main/homepage.html.twig');
    }

    /**
     * @Route(
     *     "/program-of-research",
     *     name="nb_graphics_front_site_researchprogramm",
     *     defaults={
     *          "seo": true,
     *          "page": "Page Programme de recherche"
     *     }
     *  )
     */
    public function researchProgramAction()
    {
        return $this->render('@NBGraphicsFrontSite/main/researchprogram.html.twig');
    }

    /**
     * @Route("/terms",
     *     name="nb_graphics_front_site_terms",
     *     defaults={
     *          "seo": true,
     *          "page": "Page Mentions légales"
     *     }
     *  )
     */
    public function termsAction()
    {
        return $this->render('@NBGraphicsFrontSite/main/terms.html.twig');
    }

    /**
     * @Route("/credits", name="nb_graphics_front_site_credits",
     *     defaults={
     *          "seo": true,
     *          "page": "Page Crédits"
     *     }
     *  )
     */
    public function creditsAction()
    {
        return $this->render('@NBGraphicsFrontSite/main/credits.html.twig');
    }

    /**
     * @Route("/newsletter", name="nb_graphics_front_site_newsletter",
     *     defaults={
     *          "seo": true,
     *          "page": "Page Newsletter"
     *     }
     *  )
     */
    public function newsletterAction(Request $request)
    {
        $newsletter = new Newsletter();
        $newsletterForm = $this->createForm(NewsletterFormType::class, $newsletter);
        $newsletterForm->handleRequest($request);

        if ($newsletterForm->isSubmitted() && $newsletterForm->isValid()) {

            $createEntity = $this->get('app.crud.create')->createEntity($newsletter);

            if ($createEntity) {
                $this->addFlash('success', 'Adresse email ajoutée avec succès !');
                return $this->redirectToRoute('nb_graphics_front_site_homepage');
            } else {
                $this->addFlash('error', 'Erreur lors de l\'ajout de l\'adresse email !');
                return $this->redirectToRoute('nb_graphics_front_site_newsletter');
            }

        }

        return $this->render('@NBGraphicsFrontSite/main/newsletter.html.twig', array(
            'newsletter'       => $newsletter,
            'formNewsletter'   => $newsletterForm->createView(),
        ));
    }
}