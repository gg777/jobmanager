<?php

namespace Jobmanager\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jobmanager\AdminBundle\Entity\Meeting;
use Jobmanager\AdminBundle\Form\MeetingType;
use Jobmanager\AdminBundle\Form\MeetingEditType;

class MeetingController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve meetings
        $meetings = $em->getRepository('JobmanagerAdminBundle:Meeting')
                       ->getMeetingAndCompany();

        // send view
        return $this->render('JobmanagerAdminBundle:Meeting:index.html.twig', array(
            'meetings' => $meetings
        ));
    }


    public function createAction()
    {

        // new meeting
        $meeting = new Meeting();

        // generate form
        $form = $this->createForm(new MeetingType, $meeting);

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
                $meeting->setName($meeting->getDateBegin()->format('Y-m-d H:i:s').' - '.$meeting->getCandidateJob()->getJob()->getCompany()->getName());
//                print "<pre>"; \Doctrine\Common\Util\Debug::dump($meeting->getCandidateJob()->getJob()->getCompany()->getName()); print "</pre>";
//                die;
                $em->persist($meeting);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Entretien enregistré');

                // redirect
                return $this->redirect($this->generateUrl('admin_meeting_index'));

            }

        }


        // if no post
        return $this->render('JobmanagerAdminBundle:Meeting:create-edit-meeting.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function viewAction(Meeting $meeting)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();



        // send view
        return $this->render('JobmanagerAdminBundle:Meeting:view.html.twig', array(
            'meeting' => $meeting
        ));
    }

    public function editAction(Meeting $meeting)
    {


        // generate form
        $form = $this->createForm(new MeetingEditType, $meeting);
        //die('coucou');

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
                $em->persist($meeting);
                $em->flush();

                // send flas message
                $this->get('session')->getFlashBag()->add('info', 'Rdv modifié.');

                // redirect
                return $this->redirect($this->generateUrl('admin_meeting_index'));

            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Meeting:create-edit-meeting.html.twig', array(
            'form' => $form->createView(),
            'meeting' => $meeting
        ));
    }

    public function deleteAction(Meeting $meeting)
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

                // remove meeting
                $em->remove($meeting);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Rdv supprimé.');

                // redirect
                return $this->redirect($this->generateUrl('admin_meeting_index'));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Meeting:delete.html.twig', array(
            'form' => $form->createView(),
            'meeting' => $meeting
        ));
    }
} 