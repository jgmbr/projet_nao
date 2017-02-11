<?php

namespace NBGraphics\CoreBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use NBGraphics\CoreBundle\Entity\Moderation;
use NBGraphics\CoreBundle\Entity\Observation;
use NBGraphics\CoreBundle\Entity\Status;
use NBGraphics\CoreBundle\Services\Crud\CreateDatas;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ObservationListener
{
    protected $entites = [];

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Observation) {
            return;
        }

        $entityManager = $args->getEntityManager();

        $user = $entity->getUser();

        if ($user->hasRole('ROLE_ADMIN') || $user->hasRole('ROLE_SUPER_ADMIN')) {
            return;
        }

        if ($user->hasRole('ROLE_USER')) {

            $uow = $entityManager->getUnitOfWork();

            $updates = $uow->getEntityChangeSet($entity);

            if ($updates) {

                $statut = $entityManager->getRepository(Status::class)->findOneByRole('DEFAULT');

                $entity->setStatus($statut);

                $moderation = new Moderation();
                $moderation->setComment('Observation renvoyée en validation par un modérateur');
                $moderation->setObservation($entity);
                $moderation->setStatus($statut);

                $this->entites[] = $moderation;

            }
        }

    }

    public function postFlush(PostFlushEventArgs $args)
    {
        if(!empty($this->entites)) {

            $entityManager = $args->getEntityManager();

            foreach ($this->entites as $thing) {

                $entityManager->persist($thing);
            }

            $this->entites = [];
            $entityManager->flush();
        }

    }

}