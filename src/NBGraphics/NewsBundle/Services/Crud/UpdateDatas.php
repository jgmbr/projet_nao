<?php

namespace NBGraphics\NewsBundle\Services\Crud;

use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use NBGraphics\CoreBundle\Entity\Moderation;
use NBGraphics\CoreBundle\Entity\Newsletter;
use NBGraphics\CoreBundle\Entity\Observation;
use NBGraphics\NewsBundle\Entity\Article;
use NBGraphics\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateDatas
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function updateArticle(Article $article, $andFlush = true)
    {
        if (!$article instanceof Article)
            throw new NotFoundHttpException('Article non reconnu');

        if ($article->getImage() !== null) {
            $image = $article->getImage();
            if ($image->getFile() !== null) {
                $image->setFile($image->getFile());
                $image->upload();
                $image->setArticle($article);
                $article->setImage($image);
            }
        }

        $this->em->persist($article);

        if ($andFlush)
            $this->em->flush();

        return true;
    }

}
