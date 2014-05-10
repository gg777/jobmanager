<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 09/05/2014
 * Time: 21:35
 */

namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Form\DiplomaEditType;
use Jobmanager\AdminBundle\Form\DiplomaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Jobmanager\AdminBundle\Entity\Diploma;

class DiplomaController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve diplomas
        $diplomas = $em->getRepository('JobmanagerAdminBundle:Diploma')
            ->findAll();

        // send view
        return $this->render('JobmanagerAdminBundle:Diploma:index.html.twig', array(
            'diplomas' => $diplomas
        ));
    }


    public function createAction()
    {

        // new diploma
        $diploma = new Diploma();

        // generate form
        $form = $this->createForm(new DiplomaType, $diploma);

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
                $em->persist($diploma);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Langage enregistrée');

                // redirect
                return $this->redirect($this->generateUrl('admin_diploma_index'));

            }

        }


        // if no post
        return $this->render('JobmanagerAdminBundle:Diploma:create-edit-diploma.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function viewAction(Diploma $diploma)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // send view
        return $this->render('JobmanagerAdminBundle:Diploma:view.html.twig', array(
            'diploma' => $diploma
        ));
    }

    public function editAction(Diploma $diploma)
    {
        // generate form
        $form = $this->createForm(new DiplomaEditType, $diploma);

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
                $em->persist($diploma);
                $em->flush();

                // send flas message
                $this->get('session')->getFlashMessage()->add('info', 'Langage modifié.');

                // redirect
                return $this->redirect($this->generateUrl('admin_diploma_index'));

            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Diploma:create-edit-diploma.html.twig', array(
            'form' => $form->createView(),
            'diploma' => $diploma
        ));
    }

    public function deleteAction(Diploma $diploma)
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

                // remove diploma
                $em->remove($diploma);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Langage supprimé.');

                // redirect
                return $this->redirect($this->generateUrl('admin_diploma_index'));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Diploma:delete.html.twig', array(
            'form' => $form->createView(),
            'diploma' => $diploma
        ));
    }
}