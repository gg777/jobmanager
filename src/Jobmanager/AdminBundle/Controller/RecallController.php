<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 16/05/2014
 * Time: 16:30
 */

namespace Jobmanager\AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Jobmanager\AdminBundle\Entity\Recall;
use Jobmanager\AdminBundle\Form\RecallType;

class RecallController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve recalls
        $recalls = $em->getRepository('JobmanagerAdminBundle:Recall')
                       ->findAll();

        // send view
        return $this->render('JobmanagerAdminBundle:Recall:index.html.twig', array(
            'recalls' => $recalls
        ));
    }


    public function createAction()
    {

        // new recall
        $recall = new Recall();

        // generate form
        $form = $this->createForm(new RecallType, $recall);

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
                $em->persist($recall);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Rappel enregistrée');

                // redirect
                return $this->redirect($this->generateUrl('admin_recall_index'));

            }

        }


        // if no post
        return $this->render('JobmanagerAdminBundle:Recall:create-edit-recall.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function viewAction(Recall $recall)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // send view
        return $this->render('JobmanagerAdminBundle:Recall:view.html.twig', array(
            'recall' => $recall
        ));
    }

    public function editAction(Recall $recall)
    {
        // generate form
        $form = $this->createForm(new RecallEditType, $recall);

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
                $em->persist($recall);
                $em->flush();

                // send flas message
                $this->get('session')->getFlashBag()->add('info', 'Rdv modifié.');

                // redirect
                return $this->redirect($this->generateUrl('admin_recall_index'));

            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Recall:create-edit-recall.html.twig', array(
            'form' => $form->createView(),
            'recall' => $recall
        ));
    }

    public function deleteAction(Recall $recall)
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

                // remove recall
                $em->remove($recall);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Rdv supprimé.');

                // redirect
                return $this->redirect($this->generateUrl('admin_recall_index'));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Recall:delete.html.twig', array(
            'form' => $form->createView(),
            'recall' => $recall
        ));
    }
} 