<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 09/05/2014
 * Time: 21:35
 */

namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Form\CompanyEditType;
use Jobmanager\AdminBundle\Form\CompanyType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Jobmanager\AdminBundle\Entity\Company;

class CompanyController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve companies
        $companies = $em->getRepository('JobmanagerAdminBundle:Company')
                        ->getCompanyByIdInv();

        // send view
        return $this->render('JobmanagerAdminBundle:Company:index.html.twig', array(
            'companies' => $companies
        ));
    }


    public function createAction()
    {
        // new company
        $company = new Company();

        // generate form
        $form = $this->createForm(new CompanyType, $company);

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
                $em->persist($company);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Entreprise bien enregistré');

                // redirect
                return $this->redirect($this->generateUrl('admin_company_index'));

            }

        }

        // if no post
        return $this->render('JobmanagerAdminBundle:Company:create-edit-company.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function viewAction(Company $company)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve current company by id
//        $company = $em->getRepository('JobmanagerAdminBundle:Company')
//                  ->find($company->getId());

        // send view
        return $this->render('JobmanagerAdminBundle:Company:view.html.twig', array(
            'company' => $company
        ));
    }

    public function editAction(Company $company)
    {
        // generate form
        $form = $this->createForm(new CompanyEditType, $company);

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
                $em->persist($company);
                $em->flush();

                // send flas message
                $this->get('session')->getFlashBag()->add('info', 'Entreprise modifié');

                // redirect
                return $this->redirect($this->generateUrl('admin_company_index'));

            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Company:create-edit-company.html.twig', array(
            'form' => $form->createView(),
            'company' => $company
        ));
    }

    public function deleteAction(Company $company)
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

                // remove company
                $em->remove($company);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Entreprise supprimé.');

                // redirect
                return $this->redirect($this->generateUrl('admin_company_index'));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Company:delete.html.twig', array(
            'form' => $form->createView(),
            'company' => $company
        ));
    }
}