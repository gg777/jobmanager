<?php
// src/Jobmanager/AdminBundle/Controller/JobController.php

namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Entity\Job;
use Jobmanager\AdminBundle\Form\JobType;
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

            // valid form
            if ($form->isValid()) {

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

        // if no post
        return $this->render('JobmanagerAdminBundle:Job:add-job.html.twig', array('form' => $form->createView()));

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


}