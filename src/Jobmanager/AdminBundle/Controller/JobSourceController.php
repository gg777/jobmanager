<?php

namespace Jobmanager\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jobmanager\AdminBundle\Entity\JobSource;
use Jobmanager\AdminBundle\Form\JobSourceType;
use Jobmanager\AdminBundle\Form\JobSourceEditType;

class JobSourceController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve jobsources
        $jobsources = $em->getRepository('JobmanagerAdminBundle:JobSource')
                       ->findAll();

        // send view
        return $this->render('JobmanagerAdminBundle:JobSource:index.html.twig', array(
            'jobsources' => $jobsources
        ));
    }


    public function createAction()
    {

        // new jobsource
        $jobsource = new JobSource();

        // generate form
        $form = $this->createForm(new JobSourceType, $jobsource);

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
                $em->persist($jobsource);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Rdv enregistrée');

                // redirect
                return $this->redirect($this->generateUrl('admin_jobsource_index'));

            }

        }


        // if no post
        return $this->render('JobmanagerAdminBundle:JobSource:create-edit-jobsource.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function viewAction(JobSource $jobsource)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // send view
        return $this->render('JobmanagerAdminBundle:JobSource:view.html.twig', array(
            'jobsource' => $jobsource
        ));
    }

    public function editAction(JobSource $jobsource)
    {
        // generate form
        $form = $this->createForm(new JobSourceEditType, $jobsource);

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
                $em->persist($jobsource);
                $em->flush();

                // send flas message
                $this->get('session')->getFlashBag()->add('info', 'Rdv modifié.');

                // redirect
                return $this->redirect($this->generateUrl('admin_jobsource_index'));

            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:JobSource:create-edit-jobsource.html.twig', array(
            'form' => $form->createView(),
            'jobsource' => $jobsource
        ));
    }

    public function deleteAction(JobSource $jobsource)
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

                // remove jobsource
                $em->remove($jobsource);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Rdv supprimé.');

                // redirect
                return $this->redirect($this->generateUrl('admin_jobsource_index'));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:JobSource:delete.html.twig', array(
            'form' => $form->createView(),
            'jobsource' => $jobsource
        ));
    }
} 