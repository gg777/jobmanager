<?php
// src/Jobmanager/AdminBundle/Controller/JobController.php

namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Entity\Job;
use Jobmanager\AdminBundle\Form\JobEditType;
use Jobmanager\AdminBundle\Form\JobType;
use Jobmanager\AdminBundle\Form\JobCompleteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class JobController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve jobs
        $jobs = $em->getRepository('JobmanagerAdminBundle:Job')
                   ->getJobs();

        // send view
        return $this->render('JobmanagerAdminBundle:Job:index.html.twig', array(
            'jobs' => $jobs
        ));
    }

    public function createAction()
    {
        // new job
        $job = new Job();

        // generate form
        $form = $this->createForm(new JobType, $job);

        // get request
        $request = $this->get('request');

        // check if post sent
        if ($request->getMethod() == 'POST') {




            // bind data form
            $form->handleRequest($request);

            print "<pre>"; \Doctrine\Common\Util\Debug::dump($request->request); print "</pre>";
            die;

            // valid form
            if ($form->isValid()) {

//                print "<pre>"; \Doctrine\Common\Util\Debug::dump($job); print "</pre>";
//                die;

                // save in db
                $em = $this->getDoctrine()->getManager();
                $em->persist($job);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Poste bien enregistré');

                // redirect
                return $this->redirect($this->generateUrl('admin_job_index'));

            }

        }

        // if post sent from super job form

        // if no post
        return $this->render('JobmanagerAdminBundle:Job:create-edit-job.html.twig', array(
            'form' => $form->createView()
        ));

    }


    public function editAction(Job $job)
    {
        // generate form
        $form = $this->createForm(new JobEditType, $job);

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
                $em->persist($job);
                $em->flush();

                // send flas message
                $this->get('session')->getFlashMessage()->add('info', 'Poste modifié');

                // redirect
                return $this->redirect($this->generateUrl('admin_job_index'));

            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Job:create-edit-job.html.twig', array(
            'form' => $form->createView(),
            'job' => $job
        ));
    }

    public function viewAction(Job $job)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve current job by id
        $job = $em->getRepository('JobmanagerAdminBundle:Job')
                  ->find($job->getId());

        // send view
        return $this->render('JobmanagerAdminBundle:Job:view.html.twig', array(
            'job' => $job
        ));
    }



    public function deleteAction(Job $job)
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

                // remove job
                $em->remove($job);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Poste supprimé.');

                // redirect
                return $this->redirect($this->generateUrl('admin_job_index'));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Job:delete.html.twig', array(
            'form' => $form->createView(),
            'job' => $job
        ));
    }







}