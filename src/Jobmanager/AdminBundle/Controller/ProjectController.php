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
use Jobmanager\AdminBundle\Entity\Project;
use Jobmanager\AdminBundle\Form\ProjectType;
use Jobmanager\AdminBundle\Form\ProjectEditType;

class ProjectController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve projects
        $projects = $em->getRepository('JobmanagerAdminBundle:Project')
                       ->findAll();

        // send view
        return $this->render('JobmanagerAdminBundle:Project:index.html.twig', array(
            'projects' => $projects
        ));
    }


    public function createAction()
    {

        // new project
        $project = new Project();

        // generate form
        $form = $this->createForm(new ProjectType, $project);

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
                $em->persist($project);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Projet enregistrée');

                // redirect
                return $this->redirect($this->generateUrl('admin_project_index'));

            }

        }


        // if no post
        return $this->render('JobmanagerAdminBundle:Project:create-edit-project.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function viewAction(Project $project)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // send view
        return $this->render('JobmanagerAdminBundle:Project:view.html.twig', array(
            'project' => $project
        ));
    }

    public function editAction(Project $project)
    {
        // generate form
        $form = $this->createForm(new ProjectEditType, $project);

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
                $em->persist($project);
                $em->flush();

                // send flas message
                $this->get('session')->getFlashBag()->add('info', 'Projet modifié.');

                // redirect
                return $this->redirect($this->generateUrl('admin_project_index'));

            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Project:create-edit-project.html.twig', array(
            'form' => $form->createView(),
            'project' => $project
        ));
    }

    public function deleteAction(Project $project)
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

                // remove project
                $em->remove($project);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Projet supprimé.');

                // redirect
                return $this->redirect($this->generateUrl('admin_project_index'));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Project:delete.html.twig', array(
            'form' => $form->createView(),
            'project' => $project
        ));
    }
} 