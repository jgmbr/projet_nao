<?php

namespace NBGraphics\CoreBundle\Services\Crud;

use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use NBGraphics\CoreBundle\Entity\Moderation;
use NBGraphics\CoreBundle\Entity\Newsletter;
use NBGraphics\CoreBundle\Entity\Observation;
use NBGraphics\CoreBundle\Entity\Status;
use NBGraphics\UserBundle\Entity\User;
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

    public function createModeration(Observation $observation, Status $statut, $comment, $andFlush = true)
    {
        if (!$observation instanceof Observation)
            throw new NotFoundHttpException('Observation non reconnu');

        if (!$statut instanceof Status)
            throw new NotFoundHttpException('Statut non reconnu');

        if (!$comment)
            return false;

        $moderation = new Moderation();
        $moderation->setComment($comment);
        $moderation->setObservation($observation);
        $moderation->setStatus($statut);

        $this->em->persist($moderation);

        if ($andFlush)
            $this->em->flush($moderation);

        return true;
    }

    public function createObservation(Observation $observation, User $user, $andFlush = true)
    {
        if (!$observation instanceof Observation)
            throw new NotFoundHttpException('Observation non reconnu');

        if (!is_object($user) || !$user instanceof User) {
            throw new NotFoundHttpException('Utilisateur non reconnu');
        }

        if ($observation->getImage() !== null) {
            $image = $observation->getImage();
            $image->setObservation($observation);
            $observation->setImage($image);
            $observation->getImage()->upload();
        }

        if ($user->hasRole('ROLE_ADMIN') || $user->hasRole('ROLE_SUPER_ADMIN')) {

            // Validation automatique de l'observation
            $statut = $this->em->getRepository('NBGraphicsCoreBundle:Status')->findOneByRole('VALIDED');
            $observation->setStatus($statut);
            $observation->setUser($user);
            $user->addObservation($observation);
            $moderation = new Moderation();
            $moderation->setComment('Validation automatique');
            $moderation->setObservation($observation);
            $moderation->setStatus($statut);

        } else {

            // Observation en attente
            $statut = $this->em->getRepository('NBGraphicsCoreBundle:Status')->findOneByRole('DEFAULT');
            $observation->setStatus($statut);
            $observation->setUser($user);
            $user->addObservation($observation);
            $moderation = new Moderation();
            $moderation->setComment('En attente de validation par un modérateur');
            $moderation->setObservation($observation);
            $moderation->setStatus($statut);

        }

        $this->em->persist($moderation);
        $this->em->persist($observation);

        if ($andFlush)
            $this->em->flush();

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

    public function createNewsletter(Newsletter $newsletter, $andFlush = true)
    {
        if (!is_object($newsletter) || !$newsletter instanceof Newsletter) {
            throw new NotFoundHttpException('Adresse email non reconnue');
        }

        $exist = $this->em->getRepository(Newsletter::class)->findOneByEmail($newsletter->getEmail());

        if (is_object($exist)) {
            return false;
        } else {
            $this->em->persist($newsletter);
            if ($andFlush)
                $this->em->flush();
            return true;
        }
    }

    public function createUser(User $user, $andFlush = true)
    {
        if (!is_object($user) || !$user instanceof User) {
            throw new NotFoundHttpException('Utilisateur non reconnu');
        }

        $exist = $this->em->getRepository(User::class)->findOneByEmail($user->getEmail());

        if (is_object($exist)) {
            return false;
        } else {
            $this->em->persist($user);
            if ($andFlush)
                $this->em->flush();
            return true;
        }
    }

}
