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
            $recruiterType = new RecruiterType();

            // build form
            $renderedTmpl = $this->buildEntityForm($recruiter, $recruiterType);

            // send response
            $response = new JsonResponse();
            $response->setData(array('form_data' => $renderedTmpl));
            return $response;

        }
    }

    private function buildEntityForm($Entity, $EntityType)
    {
        $em = $this->getDoctrine()->getManager();
        $className = $em->getClassMetadata(get_class($Entity))->getName();
        $className = str_replace('Jobmanager\AdminBundle\Entity\\', '', $className);

        // create new recruiter formType
        $form = $this->createForm($EntityType, $Entity);

        return $renderedTmpl = $this->container->get('templating')->render('JobmanagerAdminBundle:'.$className.':create-edit-'.strtolower($className).'-superrecall-ajax.html.twig', array(
            'form' => $form->createView()
        ));
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

            if ($company != null)
                $recruiter->setCompany($company[0]);

            // create new recall
            $recall = new Recall();

            // bind data
            $recall->setCreatedDate(new \DateTime());
            $recall->setRecallDate(new \DateTime());
            $recall->setIsFirstContact($data_form['recall']['isFirstContact']);
            $recall->setIsRecalled($data_form['recall']['isRecalled']);
            $recall->setRecruiter($recruiter);

            // save db
            $em->persist($recall);
            $em->flush();

            // send response
            $response = new JsonResponse();
            $response->setData(array('view' => $this->redirect($this->generateUrl('admin_recall_index'))));
            return $response;
        }
    }

    public function createNewCompanyFormAction()
    {
        // get request
        $request = $this->container->get('request');

        // check if ajax request
        if ($request->isXmlHttpRequest()) {

            // create new company
            $company = new Company();
            $companyForm = new CompanyType();

            // build form
            $renderedTmpl = $this->buildEntityForm($company, $companyForm);

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

            // call entity manager
            $em = $this->getDoctrine()->getManager();

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
            $recall->setRecruiter($recruiter);
            $recall->setDescription($data_form['recall']['description']);
            $recall->setIsFirstContact($data_form['recall']['isFirstContact']);
            $recall->setIsRecalled($data_form['recall']['isRecalled']);
            $recall->setIsMail($data_form['recall']['isMail']);

            if (!empty($data_form['recall']['jobsource'])) {

                $jobSourceId = $data_form['recall']['jobSource'];
                $jobSource = $em->getRepository('JobmanagerAdminBundle:JobSource')
                                ->findById($jobSourceId);

                $recall->setJobSource($jobSource);

            }

            // save db
            $em->persist($recall);
            $em->flush();

            // send response
            $response = new JsonResponse();
            $response->setData(array('view' => $this->redirect($this->generateUrl('admin_recall_index'))));
            return $response;
        }
    }
} 