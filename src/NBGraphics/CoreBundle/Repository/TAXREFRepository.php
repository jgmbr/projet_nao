<?php

namespace NBGraphics\CoreBundle\Repository;

use NBGraphics\CoreBundle\Entity\TAXREF;

/**
 * TAXREFRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TAXREFRepository extends \Doctrine\ORM\EntityRepository
{
    public function findDistinctFamilleQB()
    {
        return $this
            ->createQueryBuilder('t')
            ->groupBy('t.famille')
        ;
    }

    public function findLikeName($term)
    {
        return $this
            ->createQueryBuilder('t')
            ->orWhere('t.nomValide LIKE :term')
            ->orWhere('t.nomVern LIKE :term')
            ->setParameter('term', "%$term%")
            ->orderBy('t.nomValide')
            ->setMaxResults(15)
            ->getQuery()
            ->execute()
        ;
    }

    public function findLikeNameOrFamily($term)
    {
        return $this
            ->createQueryBuilder('t')
            ->where('t.nomComplet LIKE :term')
            ->orWhere('t.nomValide LIKE :term')
            ->orWhere('t.nomVern LIKE :term')
            ->orWhere('t.nomVernEng LIKE :term')
            ->orWhere('t.famille LIKE :term')
            ->setParameter('term', "%$term%")
            ->orderBy('t.nomComplet')
            ->setMaxResults(15)
            ->getQuery()
            ->execute()
        ;
    }

    public function countTaxref()
    {
        return $this
            ->createQueryBuilder('t')
            ->select('COUNT(t)')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
