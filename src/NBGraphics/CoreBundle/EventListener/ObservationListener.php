<?php

namespace NBGraphics\CoreBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use NBGraphics\CoreBundle\Entity\Moderation;
use NBGraphics\CoreBundle\Entity\Observation;
use NBGraphics\CoreBundle\Entity\Status;
use NBGraphics\CoreBundle\Services\Crud\CreateDatas;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ObservationListener
{
    protected $entities = [];

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var TokenStorageInterface
     */
    private $token;

    public function __construct(ContainerInterface $container, TokenStorageInterface $token)
    {
        $this->container = $container;
        $this->token = $token;
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Observation) {
            return;
        }

        $entityManager = $args->getEntityManager();

        $user = $this->token->getToken()->getUser();

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

                $this->entities[] = $moderation;

            }
        }

    }

    public function postFlush(PostFlushEventArgs $args)
    {
        if(!empty($this->entities)) {

            $entityManager = $args->getEntityManager();

            foreach ($this->entities as $entity) {

                $entityManager->persist($entity);
            }

            $this->entities = [];

            $entityManager->flush();
        }

    }

}