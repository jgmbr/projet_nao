<?php

namespace NBGraphics\NewsBundle\Services\Crud;

use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use NBGraphics\CoreBundle\Entity\Observation;
use NBGraphics\NewsBundle\Entity\Article;
use NBGraphics\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteDatas
{
    /**
    * @var EntityManagerInterface
    */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function deleteArticle(Article $article, $andFlush = true)
    {
        if (!$article instanceof Article)
            throw new NotFoundHttpException('Article non reconnu');

        $this->em->remove($article);

        if ($andFlush)
            $this->em->flush($article);

        return true;
    }

    public function deleteEntity($entity, $andFlush = true)
    {
        if (!is_object($entity))
            throw new NotFoundHttpException('Entité non reconnue');

        $this->em->remove($entity);

        if ($andFlush)
            $this->em->flush();

        return true;
    }

}
