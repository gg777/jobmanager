<?php

namespace Jobmanager\AdminBundle\Service;

use Doctrine\ORM\EntityManager;
use Jobmanager\AdminBundle\Entity\CandidateJob;

class CandidateJobMailer
{
    private $mailer;
    private $entityManager;

    public function __construct(\Swift_Mailer $mailer, EntityManager $entityManager)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;

//        print "<pre>"; \Doctrine\Common\Util\Debug::dump($templating); print "</pre>";
//        die('coucou');
    }

    public function sendCandidateJobMail(CandidateJob $candidateJob)
    {
        // send email
        $message = \Swift_Message::newInstance()
            ->setSubject('Candidature poste '.$candidateJob->getJob()->getName())
//            ->setFrom('pa@foulquier.info')
            ->setFrom($candidateJob->getCandidate()->getEmail())
            ->setTo('pa@foulquier.info')
            ->setBody('Bonjour,

Suite à votre annonce sur le site '.$candidateJob->getJob()->getJobSource()->getName().', je sollicite votre attention concernant le poste de '.$candidateJob->getJob()->getName().'.

Vous trouverez mon cv détaillé ainsi que d\'autres d\'informations sur mon profil, sur la page http://job.foulquier.info

A bientôt.

Cordialement,

Pierre-Antoine Foulquier
http://www.foulquier.info');
        $this->mailer->send($message);
    }
} 