<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * JobRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class JobRepository extends EntityRepository
{

    public function getJobs()
    {
        $qb = $this->createQueryBuilder('j');

        $qb
            ->addSelect('j')
            ->distinct('j')
            ->leftJoin('j.company', 'c')
            ->addSelect('c')
            ->orderBy('j.createdDate', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }

    public function getJobByRemixjobsId($id)
    {
        $qb = $this->createQueryBuilder('j');

        $qb
            ->addSelect('j')
            ->where('j.remixjobs_id = :remixjobsId')
            ->setParameter('remixjobsId', $id)
        ;

        return $qb->getQuery()->getResult();
    }

    public function getNewJobs()
    {
        $qb = $this->createQueryBuilder('j');

        $qb
            ->addSelect('j')
            ->where('j.isApplied = :isApplied')
            ->setParameter('isApplied', 0)
            ->andWhere('j.isNoInterest = :isNoInterest')
            ->setParameter('isNoInterest', 0)
            ->orderBy('j.createdDate', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }
}
