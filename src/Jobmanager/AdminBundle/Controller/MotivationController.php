<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 09/05/2014
 * Time: 21:35
 */

namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Form\MotivationEditType;
use Jobmanager\AdminBundle\Form\MotivationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Jobmanager\AdminBundle\Entity\Motivation;

class MotivationController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve motivations
        $motivations = $em->getRepository('JobmanagerAdminBundle:Motivation')
            ->findAll();

        // send view
        return $this->render('JobmanagerAdminBundle:Motivation:index.html.twig', array(
            'motivations' => $motivations
        ));
    }


    public function createAction()
    {

        // new motivation
        $motivation = new Motivation();

        // generate form
        $form = $this->createForm(new MotivationType, $motivation);

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
                $em->persist($motivation);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Langage enregistrée');

                // redirect
                return $this->redirect($this->generateUrl('admin_motivation_index'));

            }

        }


        // if no post
        return $this->render('JobmanagerAdminBundle:Motivation:create-edit-motivation.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function viewAction(Motivation $motivation)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // send view
        return $this->render('JobmanagerAdminBundle:Motivation:view.html.twig', array(
            'motivation' => $motivation
        ));
    }

    public function editAction(Motivation $motivation)
    {
        // generate form
        $form = $this->createForm(new MotivationEditType, $motivation);

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
                $em->persist($motivation);
                $em->flush();

                // send flas message
                $this->get('session')->getFlashBag()->add('info', 'Langage modifié.');

                // redirect
                return $this->redirect($this->generateUrl('admin_motivation_index'));

            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Motivation:create-edit-motivation.html.twig', array(
            'form' => $form->createView(),
            'motivation' => $motivation
        ));
    }

    public function deleteAction(Motivation $motivation)
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

                // remove motivation
                $em->remove($motivation);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Langage supprimé.');

                // redirect
                return $this->redirect($this->generateUrl('admin_motivation_index'));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Motivation:delete.html.twig', array(
            'form' => $form->createView(),
            'motivation' => $motivation
        ));
    }
}