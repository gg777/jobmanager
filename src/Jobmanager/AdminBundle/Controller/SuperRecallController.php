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
    /**
     * Create new recall
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
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
            $renderedTmpl = $this->buildEntityForm($recruiter, $recruiterType, 'recall');

            // send response
            $response = new JsonResponse();
            $response->setData(array('form_data' => $renderedTmpl));
            return $response;

        }
    }

    /**
     * Build Entity's form
     * @param $Entity
     * @param $EntityType
     * @param $superFormName
     * @return mixed
     */
    private function buildEntityForm($Entity, $EntityType, $superFormName)
    {
        $em = $this->getDoctrine()->getManager();
        $className = $em->getClassMetadata(get_class($Entity))->getName();
        $className = str_replace('Jobmanager\AdminBundle\Entity\\', '', $className);

        // create new recruiter formType
        $form = $this->createForm($EntityType, $Entity);

        return $renderedTmpl = $this->container->get('templating')->render('JobmanagerAdminBundle:'.$className.':create-edit-'.strtolower($className).'-super'.$superFormName.'-ajax.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Create new recruiter
     * @return JsonResponse
     */
    public function createNewRecruiterAction()
    {
        // get request
        $request = $this->container->get('request');

        // check if ajax request
        if ($request->isXmlHttpRequest()) {

            // call entity manager
            $em = $this->getDoctrine()->getManager();

            // get ajax post data
            $dataForm = $request->request->get('data_form');

            // get company id
            $companyId = $dataForm['jobmanager_adminbundle_recruiter[company'];
            $company = $em->getRepository('JobmanagerAdminBundle:Company')
                          ->findById($companyId);

            // create new recruiter
            $recruiter = $this->createRecruiter($dataForm, $company);

            // create new recall
            $recall = $this->createRecall($em, $dataForm, $recruiter);

            // save db
            $em->persist($recruiter);
            $em->persist($recall);
            $em->flush();

            // send response
            $response = new JsonResponse();
            $response->setData(array('view' => $this->redirect($this->generateUrl('JobmanagerAdminBundle_homepage'))));
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
            $renderedTmpl = $this->buildEntityForm($company, $companyForm, 'recall');

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

            // call entity manager
            $em = $this->getDoctrine()->getManager();

            // get ajax post data
            $dataForm = $request->request->get('data_form');

            // create new company
            $company = $this->createCompany($dataForm);

            // create new recruiter
            $recruiter = $this->createRecruiter($dataForm, $company);

            // create new recall
            $recall = $this->createRecall($em, $dataForm, $recruiter);

            // save db
            $em->persist($company);
            $em->persist($recruiter);
            $em->persist($recall);
            $em->flush();

            // send response
            $response = new JsonResponse();
            $response->setData(array('view' => $this->redirect($this->generateUrl('JobmanagerAdminBundle_homepage'))));
            return $response;
        }
    }

    private function createCompany($dataForm)
    {
        // create new company and bind data
        $company = new Company();
        $company->setName($dataForm['jobmanager_adminbundle_company[name']);
        $company->setType($dataForm['jobmanager_adminbundle_company[type']);
        $company->setSector($dataForm['jobmanager_adminbundle_company[sector']);
        $company->setAddress($dataForm['jobmanager_adminbundle_company[address']);
        $company->setZip($dataForm['jobmanager_adminbundle_company[zip']);
        $company->setCity($dataForm['jobmanager_adminbundle_company[city']);
        $company->setCountry($dataForm['jobmanager_adminbundle_company[country']);
        $company->setLat($dataForm['jobmanager_adminbundle_company[lat']);
        $company->setLng($dataForm['jobmanager_adminbundle_company[lng']);

        if (isset($dataForm['jobmanager_adminbundle_company[is_head_hunter']))
            $company->setIsHeadHunter($dataForm['jobmanager_adminbundle_company[is_head_hunter']);
        else
            $company->setIsHeadHunter(0);

        $company->setUrlCompany($dataForm['jobmanager_adminbundle_company[urlCompany']);

        return $company;
    }

    private function createRecruiter($dataForm, $company)
    {
        // create new recruiter
        $recruiter = new Recruiter();

        // bind data
        $recruiter->setGender($dataForm['jobmanager_adminbundle_recruiter[gender']);
        $recruiter->setFirstName($dataForm['jobmanager_adminbundle_recruiter[firstName']);
        $recruiter->setLastName($dataForm['jobmanager_adminbundle_recruiter[lastName']);
        $recruiter->setTel($dataForm['jobmanager_adminbundle_recruiter[tel']);
        $recruiter->setMobile($dataForm['jobmanager_adminbundle_recruiter[mobile']);
        $recruiter->setEmail($dataForm['jobmanager_adminbundle_recruiter[email']);

        if (is_array($company))
            $recruiter->setCompany($company[0]);
        else
            $recruiter->setCompany($company);

        return $recruiter;
    }

    private function createRecall($em, $dataForm, Recruiter $recruiter)
    {
        // create new recall
        $recall = new Recall();

        // bind data
        $createdDate = new \DateTime();
        $createdDate->setDate($dataForm['jobmanager_adminbundle_superrecall[createdDate']['date']['year'], $dataForm['jobmanager_adminbundle_superrecall[createdDate']['date']['month'], $dataForm['jobmanager_adminbundle_superrecall[createdDate']['date']['day']);
        $createdDate->setTime($dataForm['jobmanager_adminbundle_superrecall[createdDate']['time']['hour'], $dataForm['jobmanager_adminbundle_superrecall[createdDate']['time']['minute'], 0);
        $recall->setCreatedDate($createdDate);

        $recallDate = new \DateTime();
        $recallDate->setDate($dataForm['jobmanager_adminbundle_superrecall[recallDate']['date']['year'], $dataForm['jobmanager_adminbundle_superrecall[recallDate']['date']['month'], $dataForm['jobmanager_adminbundle_superrecall[recallDate']['date']['day']);
        $recall->setRecallDate($recallDate);

        if (isset($dataForm['jobmanager_adminbundle_superrecall[isFirstContact']))
            $recall->setIsFirstContact($dataForm['jobmanager_adminbundle_superrecall[isFirstContact']);
        else
            $recall->setIsFirstContact(0);

        if (isset($dataForm['jobmanager_adminbundle_superrecall[isRecalled']))
            $recall->setIsRecalled($dataForm['jobmanager_adminbundle_superrecall[isRecalled']);
        else
            $recall->setIsRecalled(0);

        if (isset($dataForm['jobmanager_adminbundle_superrecall[isMail']))
            $recall->setIsMail($dataForm['jobmanager_adminbundle_superrecall[isMail']);
        else
            $recall->setIsMail(0);

        $jobSourceId = $dataForm['jobmanager_adminbundle_superrecall[jobSource'];
        $jobSource = $em->getRepository('JobmanagerAdminBundle:JobSource')
                        ->findById($jobSourceId);
        $recall->setJobSource($jobSource[0]);

        $recall->setDescription($dataForm['jobmanager_adminbundle_superrecall[description']);
        $recall->setRecruiter($recruiter);

        return $recall;
    }
} 