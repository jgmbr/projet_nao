<?php

namespace NBGraphics\CoreBundle\Services\Crud;

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

    public function moderateObservation(Observation $observation, User $user, Moderation $moderation, $status, $andFlush = true)
    {
        if (!$observation instanceof Observation)
            throw new NotFoundHttpException('Observation non reconnu');

        if (!is_object($user) || !$user instanceof User) {
            throw new NotFoundHttpException('Utilisateur non reconnu');
        }

        if (!$moderation instanceof Moderation)
            throw new NotFoundHttpException('Modération non reconnue');

        if (!$status)
            throw new NotFoundHttpException('Statut non reconnu');

        $observation->setStatus($status);
        $observation->addModeration($moderation);

        $user->addModeration($moderation);

        $moderation->setObservation($observation);
        $moderation->setUser($user);
        $moderation->setStatus($status);

        $this->em->persist($observation);
        $this->em->persist($moderation);

        if ($andFlush)
            $this->em->flush();

        return true;
    }

    public function updateObservation(Observation $observation, $andFlush = true)
    {
        if (!$observation instanceof Observation)
            throw new NotFoundHttpException('Observation non reconnue');

        if ($observation->getImage() !== null) {
            $image = $observation->getImage();
            if ($image->getFile() !== null) {
                $image->setFile($image->getFile());
                $image->upload();
                $image->setObservation($observation);
                $observation->setImage($image);
            }
        }

        $this->em->persist($observation);

        if ($andFlush)
            $this->em->flush();

        return true;
    }

}
