<?php

namespace Jobmanager\AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MeetingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MeetingRepository extends EntityRepository
{
    public function getMeetingsByDate()
    {
        $qb = $this->createQueryBuilder('m');

        $qb
            ->orderBy('m.dateBegin', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }

    public function getRecruiterByMeeting()
    {
        $qb = $this->createQueryBuilder('m');
        $qb
            ->select('m')
            ->distinct('m')
            ->leftJoin('m.candidate_job', 'cj')
            ->addSelect('cj')
            ->leftJoin('cj.job', 'j')
            ->addSelect('j')
            ->leftJoin('j.company', 'c')
            ->addSelect('c')
            ->leftJoin('c.recruiter', 'r')
            ->addSelect('r')
            ->orderBy('m.dateBegin', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }

    public function checkIfCandidateJobHasMeeting($candidateJob)
    {
        $qb = $this->createQueryBuilder('m');

        $qb
            ->addSelect('m')
            ->where('m.candidate_job = :id')
            ->setParameter('id', $candidateJob)
        ;

        $result = $qb->getQuery()->getResult();

        // check if result
        if ($result != null) {
            return true;
        } else {
            return false;
        }
    }

    public function getMeetingsForCandidateJob(CandidateJob $candidateJob)
    {
        $qb = $this->createQueryBuilder('m');

        $qb
            ->addSelect('m')
            ->where('m.candidate_job = :candidateJob')
            ->setParameter('candidateJob', $candidateJob)
        ;

        return $qb->getQuery()->getResult();
    }
}
