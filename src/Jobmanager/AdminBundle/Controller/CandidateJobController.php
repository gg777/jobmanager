<?php

namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Form\CandidateJobEditType;
use Jobmanager\AdminBundle\Form\CandidateJobType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jobmanager\AdminBundle\Entity\CandidateJob;
use Symfony\Component\HttpFoundation\Request;

class CandidateJobController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve candidatejobs
        $candidatejobs = $em->getRepository('JobmanagerAdminBundle:CandidateJob')
                            ->getCandidateJobByDateInv();

        // send view
        return $this->render('JobmanagerAdminBundle:CandidateJob:index.html.twig', array(
            'candidatejobs' => $candidatejobs
        ));
    }


    public function createAction(Request $request)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // new candidatejob
        $candidatejob = new CandidateJob();

        // generate form
        $form = $this->createForm(new CandidateJobType($em), $candidatejob);

        // check if post sent
        if ($request->getMethod() == 'POST') {

            // get post data
            $postData = $request->request->all();

            // bind data form

            // get job id
            $jobId = $postData['jobmanager_adminbundle_candidatejob']['job'];

            // retrieve job by id
            $job = $em->getRepository('JobmanagerAdminBundle:Job')
                      ->findById($jobId);

            // set object job in post
            $postData['jobmanager_adminbundle_candidatejob']['job'] = $job[0];
            $request->request->set('jobmanager_adminbundle_candidatejob', $postData);

            // get candidate id
            $candidateId = $postData['jobmanager_adminbundle_candidatejob']['candidate'];

            // retrieve candidate by id
            $candidate = $em->getRepository('JobmanagerAdminBundle:Candidate')
                            ->findById($candidateId);

            // set object candidate in post
            $postData['jobmanager_adminbundle_candidatejob']['candidate'] = $candidate[0];

            // save in db
            $createdDate = new \DateTime();
            $createdDate->setDate($postData['jobmanager_adminbundle_candidatejob']['createdDate']['year'], $postData['jobmanager_adminbundle_candidatejob']['createdDate']['month'], $postData['jobmanager_adminbundle_candidatejob']['createdDate']['day']);
            $candidatejob->setCreatedDate($createdDate);
            $candidatejob->setName($postData['jobmanager_adminbundle_candidatejob']['job']->getName().' - '.$postData['jobmanager_adminbundle_candidatejob']['job']->getCompany()->getName());
            $candidatejob->setJob($postData['jobmanager_adminbundle_candidatejob']['job']);
            $candidatejob->setInterest($postData['jobmanager_adminbundle_candidatejob']['interest']);
            $candidatejob->setCandidate($postData['jobmanager_adminbundle_candidatejob']['candidate']);


            if (isset($postData['jobmanager_adminbundle_candidatejob']['isRejected']))
                $candidatejob->setIsRejected($postData['jobmanager_adminbundle_candidatejob']['isRejected']);


            if (isset($postData['jobmanager_adminbundle_candidatejob']['isOutdated']))
                $candidatejob->setIsOutdated($postData['jobmanager_adminbundle_candidatejob']['isOutdated']);

            $em->persist($candidatejob);
            $em->flush();

            // check if send candidate auto is checked
            if (isset($postData['jobmanager_adminbundle_candidatejob']['sendCandidateJobAuto'])) {

                // call candidateJobMailer
                $candidatejobMailer = $this->container->get('jobmanager_admin.candidate_job_mailer');

                // send mail to recruiter
                $candidatejobMailer->sendCandidateJobMail($candidatejob);

            }

            // send message
            $this->get('session')->getFlashBag()->add('notice', 'Candidature enregistrée et envoyée');

            // redirect
            return $this->redirect($this->generateUrl('admin_candidatejob_index'));
        }

        // send view
        return $this->render('JobmanagerAdminBundle:CandidateJob:create-edit-candidatejob.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function viewAction(CandidateJob $candidatejob)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // send view
        return $this->render('JobmanagerAdminBundle:CandidateJob:view.html.twig', array(
            'candidatejob' => $candidatejob
        ));
    }

    public function editAction(CandidateJob $candidatejob)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // generate form
        $form = $this->createForm(new CandidateJobEditType($em), $candidatejob);

        // get request
        $request = $this->get('request');

        // check if post sent
        if ($request->getMethod() == 'POST') {

            // bind data form
            $form->handleRequest($request);

            // valid data
            if ($form->isValid()) {

                // call entity manager
                $em = $this->getDoctrine()->getManager();

                // insert modification date
                $candidatejob->setUpdatedDate(new \DateTime());

                // persist and flush
                $em->persist($candidatejob);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Langage modifié.');

                // redirect
                return $this->redirect($this->generateUrl('admin_candidatejob_index'));

            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:CandidateJob:create-edit-candidatejob.html.twig', array(
            'form' => $form->createView(),
            'candidatejob' => $candidatejob
        ));
    }

    public function deleteAction(CandidateJob $candidatejob)
    {
        // create empty form against csrf
        $form = $this->createFormBuilder()->getForm();

        // get request
        $request = $this->get('request');

        // check if post sent
        if ($request->getMethod() == 'POST') {

            // bind data form
            $form->handleRequest($request);

            // valide data
            if ($form->isValid()) {

                // call entity manager
                $em = $this->getDoctrine()->getManager();

                // remove candidatejob
                $em->remove($candidatejob);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Langage supprimé.');

                // redirect
                return $this->redirect($this->generateUrl('admin_candidatejob_index'));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:CandidateJob:delete.html.twig', array(
            'form' => $form->createView(),
            'candidatejob' => $candidatejob
        ));
    }
}