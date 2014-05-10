<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 09/05/2014
 * Time: 21:35
 */

namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Form\CandidateJobEditType;
use Jobmanager\AdminBundle\Form\CandidateJobType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Jobmanager\AdminBundle\Entity\CandidateJob;

class CandidateJobController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve candidatejobs
        $candidatejobs = $em->getRepository('JobmanagerAdminBundle:CandidateJob')
            ->findAll();

        // send view
        return $this->render('JobmanagerAdminBundle:CandidateJob:index.html.twig', array(
            'candidatejobs' => $candidatejobs
        ));
    }


    public function createAction()
    {

        // new candidatejob
        $candidatejob = new CandidateJob();

        // generate form
        $form = $this->createForm(new CandidateJobType, $candidatejob);

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
                $em->persist($candidatejob);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Langage enregistrée');

                // redirect
                return $this->redirect($this->generateUrl('admin_candidatejob_index'));

            }

        }


        // if no post
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
        // generate form
        $form = $this->createForm(new CandidateJobEditType, $candidatejob);

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
                $em->persist($candidatejob);
                $em->flush();

                // send flas message
                $this->get('session')->getFlashMessage()->add('info', 'Langage modifié.');

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