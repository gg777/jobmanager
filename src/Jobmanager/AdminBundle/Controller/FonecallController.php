<?php

namespace Jobmanager\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jobmanager\AdminBundle\Entity\Fonecall;
use Jobmanager\AdminBundle\Form\FonecallType;
use Jobmanager\AdminBundle\Form\FonecallEditType;

class FonecallController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve fonecalls
        $fonecalls = $em->getRepository('JobmanagerAdminBundle:Fonecall')
                        ->getFonecallByDate();

        // send view
        return $this->render('JobmanagerAdminBundle:Fonecall:index.html.twig', array(
            'fonecalls' => $fonecalls
        ));
    }


    public function createAction()
    {
        // new fonecall
        $fonecall = new Fonecall();

        // generate form
        $form = $this->createForm(new FonecallType, $fonecall);

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
                $em->persist($fonecall);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Appel enregistrée');

                // redirect
                return $this->redirect($this->generateUrl('admin_fonecall_index'));

            }

        }


        // if no post
        return $this->render('JobmanagerAdminBundle:Fonecall:create-edit-fonecall.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function viewAction(Fonecall $fonecall)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // send view
        return $this->render('JobmanagerAdminBundle:Fonecall:view.html.twig', array(
            'fonecall' => $fonecall
        ));
    }

    public function editAction(Fonecall $fonecall)
    {
        // generate form
        $form = $this->createForm(new FonecallEditType, $fonecall);

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
                $em->persist($fonecall);
                $em->flush();

                // send flas message
                $this->get('session')->getFlashBag()->add('info', 'Langage modifié.');

                // redirect
                return $this->redirect($this->generateUrl('admin_fonecall_index'));

            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Fonecall:create-edit-fonecall.html.twig', array(
            'form' => $form->createView(),
            'fonecall' => $fonecall
        ));
    }

    public function deleteAction(Fonecall $fonecall)
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

                // remove fonecall
                $em->remove($fonecall);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Langage supprimé.');

                // redirect
                return $this->redirect($this->generateUrl('admin_fonecall_index'));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Fonecall:delete.html.twig', array(
            'form' => $form->createView(),
            'fonecall' => $fonecall
        ));
    }
} 