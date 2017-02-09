<?php

namespace NBGraphics\CoreBundle\Services\Crud;

use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use NBGraphics\CoreBundle\Entity\Observation;
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

    public function deleteObservation(Observation $observation, User $user, $andFlush = true)
    {
        if (!$observation instanceof Observation)
            throw new NotFoundHttpException('Observation non reconnu');

        if (!is_object($user) || !$user instanceof User) {
            throw new NotFoundHttpException('Utilisateur non reconnu');
        }

        $user->removeObservation($observation);

        $this->em->remove($observation);

        if ($andFlush)
            $this->em->flush($observation);
    }

}
