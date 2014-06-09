<?php

namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Form\CompetenceEditType;
use Jobmanager\AdminBundle\Form\CompetenceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jobmanager\AdminBundle\Entity\Competence;

class CompetenceController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve competences
        $competences = $em->getRepository('JobmanagerAdminBundle:Competence')
            ->findAll();

        // send view
        return $this->render('JobmanagerAdminBundle:Competence:index.html.twig', array(
            'competences' => $competences
        ));
    }


    public function createAction()
    {

        // new competence
        $competence = new Competence();

        // generate form
        $form = $this->createForm(new CompetenceType, $competence);

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
                $em->persist($competence);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Compétence enregistrée');

                // redirect
                return $this->redirect($this->generateUrl('admin_competence_index'));

            }

        }


        // if no post
        return $this->render('JobmanagerAdminBundle:Competence:create-edit-competence.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function viewAction(Competence $competence)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // send view
        return $this->render('JobmanagerAdminBundle:Competence:view.html.twig', array(
            'competence' => $competence
        ));
    }

    public function editAction(Competence $competence)
    {
        // generate form
        $form = $this->createForm(new CompetenceEditType, $competence);

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
                $em->persist($competence);
                $em->flush();

                // send flas message
                $this->get('session')->getFlashBag()->add('info', 'Compétence modifié.');

                // redirect
                return $this->redirect($this->generateUrl('admin_competence_index'));

            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Competence:create-edit-competence.html.twig', array(
            'form' => $form->createView(),
            'competence' => $competence
        ));
    }

    public function deleteAction(Competence $competence)
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

                // remove competence
                $em->remove($competence);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Compétence supprimé.');

                // redirect
                return $this->redirect($this->generateUrl('admin_competence_index'));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Competence:delete.html.twig', array(
            'form' => $form->createView(),
            'competence' => $competence
        ));
    }
}