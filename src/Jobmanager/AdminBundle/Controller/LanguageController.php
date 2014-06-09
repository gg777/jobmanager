<?php

namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Form\LanguageEditType;
use Jobmanager\AdminBundle\Form\LanguageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jobmanager\AdminBundle\Entity\Language;

class LanguageController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve languages
        $languages = $em->getRepository('JobmanagerAdminBundle:Language')
            ->findAll();

        // send view
        return $this->render('JobmanagerAdminBundle:Language:index.html.twig', array(
            'languages' => $languages
        ));
    }


    public function createAction()
    {

        // new language
        $language = new Language();

        // generate form
        $form = $this->createForm(new LanguageType, $language);

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
                $em->persist($language);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Langage enregistrée');

                // redirect
                return $this->redirect($this->generateUrl('admin_language_index'));

            }

        }


        // if no post
        return $this->render('JobmanagerAdminBundle:Language:create-edit-language.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function viewAction(Language $language)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // send view
        return $this->render('JobmanagerAdminBundle:Language:view.html.twig', array(
            'language' => $language
        ));
    }

    public function editAction(Language $language)
    {
        // generate form
        $form = $this->createForm(new LanguageEditType, $language);

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
                $em->persist($language);
                $em->flush();

                // send flas message
                $this->get('session')->getFlashBag()->add('info', 'Langage modifié.');

                // redirect
                return $this->redirect($this->generateUrl('admin_language_index'));

            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Language:create-edit-language.html.twig', array(
            'form' => $form->createView(),
            'language' => $language
        ));
    }

    public function deleteAction(Language $language)
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

                // remove language
                $em->remove($language);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Langage supprimé.');

                // redirect
                return $this->redirect($this->generateUrl('admin_language_index'));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Language:delete.html.twig', array(
            'form' => $form->createView(),
            'language' => $language
        ));
    }
}