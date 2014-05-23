<?php

namespace Jobmanager\AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Jobmanager\AdminBundle\Entity\Recall;
use Jobmanager\AdminBundle\Entity\Company;
use Jobmanager\AdminBundle\Entity\Recruiter;
use Jobmanager\AdminBundle\Form\SuperRecallType;
use Jobmanager\AdminBundle\Form\SuperRecallEditType;
use Jobmanager\AdminBundle\Form\RecruiterType;
use Jobmanager\AdminBundle\Form\CompanyType;


class SuperRecallController extends Controller
{
    public function createAction()
    {

        // new recall
        $recall = new Recall();

        // generate form
        $form = $this->createForm(new SuperRecallType, $recall);

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
        return $this->render('JobmanagerAdminBundle:SuperRecall:create-edit-superrecall.html.twig', array(
            'form' => $form->createView()
        ));

    }



    public function createNewRecruiterFormAction()
    {
        // get request
        $request = $this->container->get('request');

        // check if ajax request
        if ($request->isXmlHttpRequest()) {



            // get ajax post data
            $data = $request->get('data');

            // create new recruiter
            $recruiter = new Recruiter();



            // create new recruiter formType
            $form = $this->createForm(new RecruiterType(), $recruiter);


            $renderedTmpl = $this->container->get('templating')->render('JobmanagerAdminBundle:Recruiter:create-edit-recruiter-superrecall-ajax.html.twig', array(
                'form' => $form->createView()
            ));

//            print "<pre>"; \Doctrine\Common\Util\Debug::dump($viewForm); print "</pre>";
//            die;

            // send response
            $response = new JsonResponse();
            $response->setData(array('form_data' => $renderedTmpl));
            return $response;



        }
    }

    public function createNewRecruiterAction()
    {
        // get request
        $request = $this->container->get('request');

        // check if ajax request
        if ($request->isXmlHttpRequest()) {

            // call entity manager
            $em = $this->getDoctrine()->getManager();

            // get ajax post data
            $data_form = $request->request->get('data_form');

//            print "<pre>"; \Doctrine\Common\Util\Debug::dump($data_form); print "</pre>";
//            die;


            // create new recruiter
            $recruiter = new Recruiter();


            // bind data
            $recruiter->setGender($data_form['recruiter']['gender']);
            $recruiter->setFirstName($data_form['recruiter']['firstName']);
            $recruiter->setLastName($data_form['recruiter']['lastName']);
            $recruiter->setTel($data_form['recruiter']['tel']);
            $recruiter->setEmail($data_form['recruiter']['email']);

            $companyId = $data_form['recruiter']['companyId'];
            $company = $em->getRepository('JobmanagerAdminBundle:Company')
                          ->findById($companyId);

            $recruiter->setCompany($company[0]);



            // create new recall
            $recall = new Recall();

            // bind data
            $recall->setCreatedDate(new \DateTime());
            $recall->setRecallDate(new \DateTime());
            $recall->setIsFirstContact($data_form['recall']['isFirstContact']);
            $recall->setIsRecalled($data_form['recall']['isRecalled']);
            $recall->setRecruiter($recruiter);

//            print "<pre>"; print_r($data_form); print "</pre>";
//            die;


            // save db

//            $em->persist($recruiter);
            $em->persist($recall);
            $em->flush();

            die('coucou');

            // redirect create action with parameter company id


        }
    }

    public function createNewCompanyFormAction()
    {
        // get request
        $request = $this->container->get('request');

        // check if ajax request
        if ($request->isXmlHttpRequest()) {



            // get ajax post data
            $data = $request->get('data');

            // create new company
            $company = new Company();



            // create new company formType
            $form = $this->createForm(new CompanyType(), $company);


            $renderedTmpl = $this->container->get('templating')->render('JobmanagerAdminBundle:Company:create-edit-company-superrecall-ajax.html.twig', array(
                'form' => $form->createView()
            ));

//            print "<pre>"; \Doctrine\Common\Util\Debug::dump($viewForm); print "</pre>";
//            die;

            // send response
            $response = new JsonResponse();
            $response->setData(array('form_data' => $renderedTmpl));
            return $response;



        }
    }

    public function createNewCompanyAction()
    {
        // get request
        $request = $this->container->get('request');

        // check if ajax request
        if ($request->isXmlHttpRequest()) {

            // get ajax post data
            $data_form = $request->request->get('data_form');

            // create new company
            $company = new Company();

            // bind data
            $company->setName($data_form['company']['name']);
            $company->setAddress($data_form['company']['address']);
            $company->setZip($data_form['company']['zip']);
            $company->setCity($data_form['company']['city']);
            $company->setCountry($data_form['company']['country']);
            $company->setLat($data_form['company']['lat']);
            $company->setLng($data_form['company']['lng']);
            $company->setIsHeadHunter($data_form['company']['isHeadHunter']);
            $company->setUrlCompany($data_form['company']['urlCompany']);

            // create new recruiter
            $recruiter = new Recruiter();

//            print "<pre>"; \Doctrine\Common\Util\Debug::dump($data_form); print "</pre>";
//            die;

            // bind data
            $recruiter->setCompany($company);
            $recruiter->setGender($data_form['recruiter']['gender']);
            $recruiter->setFirstName($data_form['recruiter']['firstName']);
            $recruiter->setLastName($data_form['recruiter']['lastName']);
            $recruiter->setMobile($data_form['recruiter']['mobile']);
            $recruiter->setTel($data_form['recruiter']['tel']);
            $recruiter->setEmail($data_form['recruiter']['email']);

            // create new recall
            $recall = new Recall();

            // bind data
            $recall->setCreatedDate(new \DateTime());
            $recall->setRecallDate(new \DateTime());
            $recall->setRecruiter($recruiter);
            $recall->setDescription($data_form['recall']['description']);
            $recall->setIsFirstContact($data_form['recall']['isFirstContact']);
            $recall->setIsRecalled($data_form['recall']['isRecalled']);
            //$recall->setJobSource()


            // save db
            $em = $this->getDoctrine()->getManager();
            $em->persist($recall);
            $em->flush();

            die('coucou');

            // redirect create action with parameter company id


        }
    }
} 