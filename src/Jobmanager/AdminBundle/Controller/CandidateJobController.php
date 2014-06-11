<?php

namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Form\CandidateJobEditType;
use Jobmanager\AdminBundle\Form\CandidateJobType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jobmanager\AdminBundle\Entity\CandidateJob;

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


    public function createAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // new candidatejob
        $candidatejob = new CandidateJob();

        // generate form
        $form = $this->createForm(new CandidateJobType($em), $candidatejob);

        // get request
        $request = $this->get('request');

        // check if post sent
        if ($request->getMethod() == 'POST') {

            // bind data form
            $form->handleRequest($request);

            // valid form
            if ($form->isValid()) {

                // save in db
                $em = $this->getDoctrine()->getManager();
                $candidatejob->setName($candidatejob->getJob()->getName().' - '.$candidatejob->getJob()->getCompany()->getName());
                $em->persist($candidatejob);

                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Candidature enregistrée');

                // redirect
                return $this->redirect($this->generateUrl('admin_candidatejob_index'));

            }

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

                // send flas message
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