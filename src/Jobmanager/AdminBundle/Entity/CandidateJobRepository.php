<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CandidateJobRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CandidateJobRepository extends EntityRepository
{
    public function getCandidateJobByDateInv()
    {
        $qb =$this->createQueryBuilder('cj');

        $qb->orderBy('cj.createdDate', 'DESC');

        return $qb->getQuery()->getResult();
    }

//    public function getActualCandidateJobs()
//    {
//        $qb = $this->createQueryBuilder('cj');
//
//        $qb
//            ->addSelect('cj')
//            ->distinct('cj')
//            ->leftJoin('cj.job', 'j')
//            ->addSelect('j')
//            ->leftJoin('j.company', 'c')
//            ->addSelect('c')
//            ->leftJoin('c.recruiter', 'r')
//            ->addSelect('r')
//            ->where('cj.isRejected = :isRejected')
//            ->setParameter('isRejected', 0)
//            ->andWhere('cj.isOutdated = :isOutdated')
//            ->setParameter('isOutdated', 0)
//            ->orderBy('cj.createdDate', 'DESC')
//        ;
//
//        return $qb->getQuery()->getResult();
//    }

    public function getActualCandidateJobs()
    {
        $qb = $this->createQueryBuilder('cj');

        $qb
            ->addSelect('cj')
            ->distinct('cj')
            ->leftJoin('cj.job', 'j')
            ->addSelect('j')
            ->leftJoin('j.company', 'c')
            ->addSelect('c')
//            ->leftJoin('c.recruiter', 'r')
//            ->addSelect('r')
            ->where('cj.isRejected = :isRejected')
            ->setParameter('isRejected', 0)
            ->andWhere('cj.isOutdated = :isOutdated')
            ->setParameter('isOutdated', 0)
            ->orderBy('cj.createdDate', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }
}
