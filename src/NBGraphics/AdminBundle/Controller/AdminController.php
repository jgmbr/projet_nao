<?php

namespace NBGraphics\AdminBundle\Controller;

use NBGraphics\CoreBundle\Entity\Observation;
use NBGraphics\CoreBundle\Entity\TAXREF;
use NBGraphics\NewsBundle\Entity\Article;
use NBGraphics\NewsBundle\Entity\State;
use NBGraphics\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/index", name="admin_page")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $countObservations = $em->getRepository(Observation::class)->countObservations();

        $countTaxref = $em->getRepository(TAXREF::class)->countTaxref();

        $countArticles = $em->getRepository(Article::class)->countArticles();

        $standBy = $em->getRepository(Article::class)->countArticlesByState(
          $em->getRepository(State::class)->findOneByRole('DEFAULT')
        );

        $pulished = $em->getRepository(Article::class)->countArticlesByState(
            $em->getRepository(State::class)->findOneByRole('PUBLISH')
        );

        $users = $em->getRepository(User::class)->findCountAll();

        return $this->render('NBGraphicsAdminBundle:Common:index.html.twig',array(
            'user' => $this->getUser(),
            'countObservations' => $countObservations,
            'countTaxref' => $countTaxref,
            'countArticles' => $countArticles,
            'standBy' => $standBy,
            'published' => $pulished,
            'countUsers' => $users
        ));
    }
}