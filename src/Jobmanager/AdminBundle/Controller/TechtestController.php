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
use Jobmanager\AdminBundle\Entity\Techtest;
use Jobmanager\AdminBundle\Form\TechtestType;

class TechtestController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve techtests
        $techtests = $em->getRepository('JobmanagerAdminBundle:Techtest')
                       ->findAll();

        // send view
        return $this->render('JobmanagerAdminBundle:Techtest:index.html.twig', array(
            'techtests' => $techtests
        ));
    }


    public function createAction()
    {

        // new techtest
        $techtest = new Techtest();

        // generate form
        $form = $this->createForm(new TechtestType, $techtest);

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
                $em->persist($techtest);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Rdv enregistrée');

                // redirect
                return $this->redirect($this->generateUrl('admin_techtest_index'));

            }

        }


        // if no post
        return $this->render('JobmanagerAdminBundle:Techtest:create-edit-techtest.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function viewAction(Techtest $techtest)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // send view
        return $this->render('JobmanagerAdminBundle:Techtest:view.html.twig', array(
            'techtest' => $techtest
        ));
    }

    public function editAction(Techtest $techtest)
    {
        // generate form
        $form = $this->createForm(new TechtestEditType, $techtest);

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
                $em->persist($techtest);
                $em->flush();

                // send flas message
                $this->get('session')->getFlashMessage()->add('info', 'Rdv modifié.');

                // redirect
                return $this->redirect($this->generateUrl('admin_techtest_index'));

            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Techtest:create-edit-techtest.html.twig', array(
            'form' => $form->createView(),
            'techtest' => $techtest
        ));
    }

    public function deleteAction(Techtest $techtest)
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

                // remove techtest
                $em->remove($techtest);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Rdv supprimé.');

                // redirect
                return $this->redirect($this->generateUrl('admin_techtest_index'));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Techtest:delete.html.twig', array(
            'form' => $form->createView(),
            'techtest' => $techtest
        ));
    }
} 