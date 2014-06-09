<?php

namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Form\JobExperienceEditType;
use Jobmanager\AdminBundle\Form\JobExperienceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jobmanager\AdminBundle\Entity\JobExperience;

class JobExperienceController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve jobexperiences
        $jobexperiences = $em->getRepository('JobmanagerAdminBundle:JobExperience')
            ->findAll();

        // send view
        return $this->render('JobmanagerAdminBundle:JobExperience:index.html.twig', array(
            'jobexperiences' => $jobexperiences
        ));
    }


    public function createAction()
    {

        // new jobexperience
        $jobexperience = new JobExperience();

        // generate form
        $form = $this->createForm(new JobExperienceType, $jobexperience);
        //die('coucou');

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
                $em->persist($jobexperience);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Langage enregistrée');

                // redirect
                return $this->redirect($this->generateUrl('admin_jobexperience_index'));

            }

        }


        // if no post
        return $this->render('JobmanagerAdminBundle:JobExperience:create-edit-jobexperience.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function viewAction(JobExperience $jobexperience)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // send view
        return $this->render('JobmanagerAdminBundle:JobExperience:view.html.twig', array(
            'jobexperience' => $jobexperience
        ));
    }

    public function editAction(JobExperience $jobexperience)
    {
        // generate form
        $form = $this->createForm(new JobExperienceEditType, $jobexperience);

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
                $em->persist($jobexperience);
                $em->flush();

                // send flas message
                $this->get('session')->getFlashBag()->add('info', 'Langage modifié.');

                // redirect
                return $this->redirect($this->generateUrl('admin_jobexperience_index'));

            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:JobExperience:create-edit-jobexperience.html.twig', array(
            'form' => $form->createView(),
            'jobexperience' => $jobexperience
        ));
    }

    public function deleteAction(JobExperience $jobexperience)
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

                // remove jobexperience
                $em->remove($jobexperience);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Langage supprimé.');

                // redirect
                return $this->redirect($this->generateUrl('admin_jobexperience_index'));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:JobExperience:delete.html.twig', array(
            'form' => $form->createView(),
            'jobexperience' => $jobexperience
        ));
    }
}