<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;


/**
 * TechtestRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TechtestRepository extends EntityRepository
{
    public function getTechtestByIdInv()
    {
        $qb = $this->createQueryBuilder('t');

        $qb->orderBy('t.id', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function getTestsForMeeting(Meeting $meeting)
    {
        $qb = $this->createQueryBuilder('t');

        $qb
            ->addSelect('t')
            ->where('t.meeting = :meeting')
            ->setParameter('meeting', $meeting)
        ;

        return $qb->getQuery()->getResult();
    }
}
