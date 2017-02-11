<?php

namespace NBGraphics\NewsBundle\Services\Crud;

use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use NBGraphics\CoreBundle\Entity\Moderation;
use NBGraphics\CoreBundle\Entity\Newsletter;
use NBGraphics\CoreBundle\Entity\Observation;
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

}
