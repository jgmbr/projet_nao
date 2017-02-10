<?php

namespace NBGraphics\NewsBundle\Controller;

use NBGraphics\NewsBundle\Entity\Article;
use NBGraphics\NewsBundle\Entity\State;
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
     * @Route("/list/{page}", name="article_list", defaults={"page": 1})
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $page = (int)$page;

        $em = $this->getDoctrine()->getManager();

        $maxArticles = (int)$this->getParameter('nb_graphics_news.pagination.max_per_page');

        $countArticles = $em->getRepository(Article::class)->countArticlesByState(
            $em->getRepository(State::class)->findOneByRole('PUBLISH')
        );

        $pagination = array(
            'page' => $page,
            'route' => 'article_list',
            'pages_count' => ceil($countArticles / $maxArticles),
            'route_params' => array()
        );

        $articles = $em->getRepository(Article::class)->listArticles(
            $em->getRepository(State::class)->findOneByRole('PUBLISH'),
            $page,
            $maxArticles
        );

        return $this->render('NBGraphicsNewsBundle:pages:list.html.twig', array(
            'articles' => $articles,
            'pagination' => $pagination
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
