<?php

namespace NBGraphics\NewsBundle\Services\Crud;

use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use NBGraphics\CoreBundle\Entity\Moderation;
use NBGraphics\CoreBundle\Entity\Newsletter;
use NBGraphics\CoreBundle\Entity\Observation;
use NBGraphics\NewsBundle\Entity\Article;
use NBGraphics\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CreateDatas
{
    /**
    * @var EntityManagerInterface
    */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createArticle(Article $article, $andFlush = true)
    {
        if (!$article instanceof Article)
            throw new NotFoundHttpException('Article non reconnu');

        if ($article->getImage() !== null) {
            $image = $article->getImage();
            $image->setArticle($article);
            $article->setImage($image);
            $article->getImage()->upload();
        }

        $this->em->persist($article);

        if ($andFlush)
            $this->em->flush($article);

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
