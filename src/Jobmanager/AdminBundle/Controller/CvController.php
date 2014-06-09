<?php

namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Form\CvEditType;
use Jobmanager\AdminBundle\Form\CvType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jobmanager\AdminBundle\Entity\Cv;

class CvController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve cvs
        $cvs = $em->getRepository('JobmanagerAdminBundle:Cv')
            ->findAll();

        // send view
        return $this->render('JobmanagerAdminBundle:Cv:index.html.twig', array(
            'cvs' => $cvs
        ));
    }


    public function createAction()
    {

        // new cv
        $cv = new Cv();

        // generate form
        $form = $this->createForm(new CvType, $cv);

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
                $em->persist($cv);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Langage enregistrée');

                // redirect
                return $this->redirect($this->generateUrl('admin_cv_index'));

            }

        }


        // if no post
        return $this->render('JobmanagerAdminBundle:Cv:create-edit-cv.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function viewAction(Cv $cv)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // send view
        return $this->render('JobmanagerAdminBundle:Cv:view.html.twig', array(
            'cv' => $cv
        ));
    }

    public function editAction(Cv $cv)
    {
        // generate form
        $form = $this->createForm(new CvEditType, $cv);

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
                $em->persist($cv);
                $em->flush();

                // send flas message
                $this->get('session')->getFlashBag()->add('info', 'Langage modifié.');

                // redirect
                return $this->redirect($this->generateUrl('admin_cv_index'));

            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Cv:create-edit-cv.html.twig', array(
            'form' => $form->createView(),
            'cv' => $cv
        ));
    }

    public function deleteAction(Cv $cv)
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

                // remove cv
                $em->remove($cv);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Langage supprimé.');

                // redirect
                return $this->redirect($this->generateUrl('admin_cv_index'));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Cv:delete.html.twig', array(
            'form' => $form->createView(),
            'cv' => $cv
        ));
    }
}