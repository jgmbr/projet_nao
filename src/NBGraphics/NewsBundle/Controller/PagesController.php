<?php

namespace NBGraphics\NewsBundle\Controller;

use NBGraphics\NewsBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Article controller.
 *
 * @Route("news")
 */
class PagesController extends Controller
{
    /**
     * Lists all article entities.
     *
     * @Route("/", name="article_list")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('NBGraphicsNewsBundle:Article')->findAll();

        return $this->render('NBGraphicsNewsBundle:pages:list.html.twig', array(
            'articles' => $articles
        ));
    }

    /**
     * Finds and displays a article entity.
     *
     * @Route("/{id}-{slug}", name="article_view")
     * @Method("GET")
     */
    public function showAction(Article $article)
    {
        return $this->render('NBGraphicsNewsBundle:pages:view.html.twig', array(
            'article' => $article
        ));
    }

    public function menuTopAction()
    {
        return $this->render('NBGraphicsNewsBundle:pages:menu_top.html.twig');
    }
}
