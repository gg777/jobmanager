<?php

namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Form\CandidateEditType;
use Jobmanager\AdminBundle\Form\CandidateType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jobmanager\AdminBundle\Entity\Candidate;

class CandidateController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve candidates
        $candidates = $em->getRepository('JobmanagerAdminBundle:Candidate')
            ->findAll();

        // send view
        return $this->render('JobmanagerAdminBundle:Candidate:index.html.twig', array(
            'candidates' => $candidates
        ));
    }


    public function createAction()
    {

        // new candidate
        $candidate = new Candidate();

        // generate form
        $form = $this->createForm(new CandidateType, $candidate);

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
                $em->persist($candidate);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Candidat bien enregistré');

                // redirect
                return $this->redirect($this->generateUrl('admin_candidate_index'));

            }

        }
//        die('coucou');

        // if no post
        return $this->render('JobmanagerAdminBundle:Candidate:create-edit-candidate.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function viewAction(Candidate $candidate)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // send view
        return $this->render('JobmanagerAdminBundle:Candidate:view.html.twig', array(
            'candidate' => $candidate
        ));
    }

    public function editAction(Candidate $candidate)
    {
        // generate form
        $form = $this->createForm(new CandidateEditType, $candidate);

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

                // persist and flush
                $em->persist($candidate);
                $em->flush();

                // send flas message
                $this->get('session')->getFlashBag()->add('info', 'Candidat modifié.');

                // redirect
                return $this->redirect($this->generateUrl('admin_candidate_index'));

            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Candidate:create-edit-candidate.html.twig', array(
            'form' => $form->createView(),
            'candidate' => $candidate
        ));
    }

    public function deleteAction(Candidate $candidate)
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

                // remove candidate
                $em->remove($candidate);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Candidat supprimé.');

                // redirect
                return $this->redirect($this->generateUrl('admin_candidate_index'));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Candidate:delete.html.twig', array(
            'form' => $form->createView(),
            'candidate' => $candidate
        ));
    }
}