<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 09/05/2014
 * Time: 21:35
 */

namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Form\FormationEditType;
use Jobmanager\AdminBundle\Form\FormationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Jobmanager\AdminBundle\Entity\Formation;

class FormationController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve formations
        $formations = $em->getRepository('JobmanagerAdminBundle:Formation')
            ->findAll();

        // send view
        return $this->render('JobmanagerAdminBundle:Formation:index.html.twig', array(
            'formations' => $formations
        ));
    }


    public function createAction()
    {

        // new formation
        $formation = new Formation();

        // generate form
        $form = $this->createForm(new FormationType, $formation);

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
                $em->persist($formation);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Langage enregistrée');

                // redirect
                return $this->redirect($this->generateUrl('admin_formation_index'));

            }

        }


        // if no post
        return $this->render('JobmanagerAdminBundle:Formation:create-edit-formation.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function viewAction(Formation $formation)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // send view
        return $this->render('JobmanagerAdminBundle:Formation:view.html.twig', array(
            'formation' => $formation
        ));
    }

    public function editAction(Formation $formation)
    {
        // generate form
        $form = $this->createForm(new FormationEditType, $formation);

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
                $em->persist($formation);
                $em->flush();

                // send flas message
                $this->get('session')->getFlashBag()->add('info', 'Langage modifié.');

                // redirect
                return $this->redirect($this->generateUrl('admin_formation_index'));

            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Formation:create-edit-formation.html.twig', array(
            'form' => $form->createView(),
            'formation' => $formation
        ));
    }

    public function deleteAction(Formation $formation)
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

                // remove formation
                $em->remove($formation);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Langage supprimé.');

                // redirect
                return $this->redirect($this->generateUrl('admin_formation_index'));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Formation:delete.html.twig', array(
            'form' => $form->createView(),
            'formation' => $formation
        ));
    }
}