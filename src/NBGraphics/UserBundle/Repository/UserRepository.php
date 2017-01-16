<?php

namespace NBGraphics\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use NBGraphics\UserBundle\Entity\User;

class UserRepository extends EntityRepository
{
    /**
     * @return User[]
     */
    public function findAllUsers()
    {
        $qb = $this->createQueryBuilder('u');

        return $qb
            ->where($qb->expr()->notLike('u.roles', ':role'))
            ->setParameter('role', '%"ROLE_ADMIN"%')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return User[]
     */
    public function findAllAdmin()
    {
        $qb = $this->createQueryBuilder('u');

        return $qb
            ->where($qb->expr()->like('u.roles', ':role'))
            ->setParameter('role', '%"ROLE_ADMIN"%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findCountUsers()
    {
        $qb = $this->createQueryBuilder('u');

        return $qb
            ->select('COUNT(u)')
            ->where($qb->expr()->notLike('u.roles', ':role'))
            ->setParameter('role', '%"ROLE_ADMIN"%')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function findCountAdmin()
    {
        $qb = $this->createQueryBuilder('u');

        return $qb
            ->select('COUNT(u)')
            ->where($qb->expr()->like('u.roles', ':role'))
            ->setParameter('role', '%"ROLE_ADMIN"%')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
