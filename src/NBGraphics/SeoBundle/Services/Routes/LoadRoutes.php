<?php

namespace NBGraphics\SeoBundle\Services\Routes;

use Doctrine\ORM\EntityManagerInterface;
use NBGraphics\SeoBundle\Entity\Seo;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

class LoadRoutes
{
    /**
    * @var EntityManagerInterface
    */
    private $em;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(EntityManagerInterface $em, RouterInterface $router)
    {
        $this->em = $em;

        $this->router = $router;
    }

    public function loadRoutes()
    {
        $routes = $this->router->getRouteCollection()->all();

        $arrSeo = array();
        $i = 0;

        foreach ($routes as $route => $params) {
            if (true === $params->getDefault('seo')) {
                $arrSeo[$i]['route'] = $route;
                $arrSeo[$i]['page'] = $params->getDefault('page');

                $exist = $this->em->getRepository(Seo::class)->findOneByRoute($route);

                if (!$exist) {
                    // create route in seo class
                    $seo = new Seo();
                    $seo->setPage($params->getDefault('page'));
                    $seo->setRoute($route);
                    $this->createEntity($seo);
                }

                $i++;
            }
        }

        return true;
    }

    public function createEntity($entity, $andFlush = true)
    {
        if (!is_object($entity))
            throw new NotFoundHttpException('Entité non reconnue');

        $this->em->persist($entity);

        if ($andFlush)
            $this->em->flush();

        return true;
    }

}
