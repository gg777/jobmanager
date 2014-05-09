<?php
// src/Jobmanager/AdminBundle/Controller/JobController.php

namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Entity\Job;
use Jobmanager\AdminBundle\Form\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class JobController extends Controller
{
    /**
     * Create
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createAction()
    {
        // create new job
        $job = new Job();

        // create form
        $form = $this->createForm(new JobType, $job);

        // get request
        $request = $this->get('request');

        // check if post sent
        if ($request->getMethod() == 'POST') {

            // handle request
            $form->handleRequest($request);

            // check if form is valid
            if($form->isValid()) {

                // call entity manager
                $em = $this->getDoctrine()->getManager();

                // persist job
                $em->persist($job);
                $em->flush();

                // add flash message
                $this->get('session')->getFlashBag()->add('infos', 'Poste ajouté.');

                // send redirection
                return $this->redirect($this->generateUrl('admin_job_index', array(
                    'id' => $job->getId()
                )));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Job:add-job.html.twig', array(
            'form' => $form->createView()
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

    public function editAction(Job $job)
    {}

    public function deleteAction(Job $job)
    {}
} 