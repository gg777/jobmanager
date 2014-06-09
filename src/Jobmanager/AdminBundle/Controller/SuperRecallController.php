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
            $data_form = $request->request->get('data_form');

            // create new recruiter
            $recruiter = new Recruiter();

            // bind data
            $recruiter->setGender($data_form['jobmanager_adminbundle_recruiter[gender']);
            $recruiter->setFirstName($data_form['jobmanager_adminbundle_recruiter[firstName']);
            $recruiter->setLastName($data_form['jobmanager_adminbundle_recruiter[lastName']);
            $recruiter->setTel($data_form['jobmanager_adminbundle_recruiter[tel']);
            $recruiter->setMobile($data_form['jobmanager_adminbundle_recruiter[mobile']);
            $recruiter->setEmail($data_form['jobmanager_adminbundle_recruiter[email']);

            $companyId = $data_form['jobmanager_adminbundle_recruiter[company'];
            $company = $em->getRepository('JobmanagerAdminBundle:Company')
                          ->findById($companyId);

            if ($company != null)
                $recruiter->setCompany($company[0]);

            // create new recall
            $recall = new Recall();

            // bind data
            $createdDate = new \DateTime();
            $createdDate->setDate($data_form['jobmanager_adminbundle_superrecall[createdDate']['date']['year'], $data_form['jobmanager_adminbundle_superrecall[createdDate']['date']['month'], $data_form['jobmanager_adminbundle_superrecall[createdDate']['date']['day']);
            $createdDate->setTime($data_form['jobmanager_adminbundle_superrecall[createdDate']['time']['hour'], $data_form['jobmanager_adminbundle_superrecall[createdDate']['time']['minute'], 0);
            $recall->setCreatedDate($createdDate);

            $recallDate = new \DateTime();
            $recallDate->setDate($data_form['jobmanager_adminbundle_superrecall[recallDate']['date']['year'], $data_form['jobmanager_adminbundle_superrecall[recallDate']['date']['month'], $data_form['jobmanager_adminbundle_superrecall[recallDate']['date']['day']);
            $recall->setRecallDate($recallDate);

            if (isset($data_form['jobmanager_adminbundle_superrecall[isFirstContact']))
                $recall->setIsFirstContact($data_form['jobmanager_adminbundle_superrecall[isFirstContact']);
            else
                $recall->setIsFirstContact(0);

//            print '<pre>'; print_r($data_form); print '</pre>';
//            die('coucou');

            if (isset($data_form['jobmanager_adminbundle_superrecall[isRecalled']))
                $recall->setIsRecalled($data_form['jobmanager_adminbundle_superrecall[isRecalled']);
            else
                $recall->setIsRecalled(0);

            if (isset($data_form['jobmanager_adminbundle_superrecall[isMail']))
                $recall->setIsMail($data_form['jobmanager_adminbundle_superrecall[isMail']);
            else
                $recall->setIsMail(0);

            $jobSourceId = $data_form['jobmanager_adminbundle_superrecall[jobSource'];
            $jobSource = $em->getRepository('JobmanagerAdminBundle:JobSource')
                            ->findById($jobSourceId);
            $recall->setJobSource($jobSource[0]);

            $recall->setDescription($data_form['jobmanager_adminbundle_superrecall[description']);
            $recall->setRecruiter($recruiter);

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
            $data_form = $request->request->get('data_form');

//            print '<pre>'; print_r($data_form); print '</pre>';
//            die('coucou');

            // create new company
            $company = new Company();
            $company->setName($data_form['jobmanager_adminbundle_company[name']);
            $company->setType($data_form['jobmanager_adminbundle_company[type']);
            $company->setSector($data_form['jobmanager_adminbundle_company[sector']);
            $company->setAddress($data_form['jobmanager_adminbundle_company[address']);
            $company->setZip($data_form['jobmanager_adminbundle_company[zip']);
            $company->setCity($data_form['jobmanager_adminbundle_company[city']);
            $company->setCountry($data_form['jobmanager_adminbundle_company[country']);
            $company->setLat($data_form['jobmanager_adminbundle_company[lat']);
            $company->setLng($data_form['jobmanager_adminbundle_company[lng']);

            if (isset($data_form['jobmanager_adminbundle_company[is_head_hunter']))
                $company->setIsHeadHunter($data_form['jobmanager_adminbundle_company[is_head_hunter']);
            else
                $company->setIsHeadHunter(0);

            $company->setUrlCompany($data_form['jobmanager_adminbundle_company[urlCompany']);

            // create new recruiter
            $recruiter = new Recruiter();

            // bind data
            $recruiter->setGender($data_form['jobmanager_adminbundle_recruiter[gender']);
            $recruiter->setFirstName($data_form['jobmanager_adminbundle_recruiter[firstName']);
            $recruiter->setLastName($data_form['jobmanager_adminbundle_recruiter[lastName']);
            $recruiter->setTel($data_form['jobmanager_adminbundle_recruiter[tel']);
            $recruiter->setMobile($data_form['jobmanager_adminbundle_recruiter[mobile']);
            $recruiter->setEmail($data_form['jobmanager_adminbundle_recruiter[email']);
            $recruiter->setCompany($company);

            // create new recall
            $recall = new Recall();

            // bind data
            $createdDate = new \DateTime();
            $createdDate->setDate($data_form['jobmanager_adminbundle_superrecall[createdDate']['date']['year'], $data_form['jobmanager_adminbundle_superrecall[createdDate']['date']['month'], $data_form['jobmanager_adminbundle_superrecall[createdDate']['date']['day']);
            $createdDate->setTime($data_form['jobmanager_adminbundle_superrecall[createdDate']['time']['hour'], $data_form['jobmanager_adminbundle_superrecall[createdDate']['time']['minute'], 0);
            $recall->setCreatedDate($createdDate);

            $recallDate = new \DateTime();
            $recallDate->setDate($data_form['jobmanager_adminbundle_superrecall[recallDate']['date']['year'], $data_form['jobmanager_adminbundle_superrecall[recallDate']['date']['month'], $data_form['jobmanager_adminbundle_superrecall[recallDate']['date']['day']);
            $recall->setRecallDate($recallDate);

            if (isset($data_form['jobmanager_adminbundle_superrecall[isFirstContact']))
                $recall->setIsFirstContact($data_form['jobmanager_adminbundle_superrecall[isFirstContact']);
            else
                $recall->setIsFirstContact(0);



            if (isset($data_form['jobmanager_adminbundle_superrecall[isRecalled']))
                $recall->setIsRecalled($data_form['jobmanager_adminbundle_superrecall[isRecalled']);
            else
                $recall->setIsRecalled(0);

            if (isset($data_form['jobmanager_adminbundle_superrecall[isMail']))
                $recall->setIsMail($data_form['jobmanager_adminbundle_superrecall[isMail']);
            else
                $recall->setIsMail(0);

            $jobSourceId = $data_form['jobmanager_adminbundle_superrecall[jobSource'];
            $jobSource = $em->getRepository('JobmanagerAdminBundle:JobSource')
                ->findById($jobSourceId);
            $recall->setJobSource($jobSource[0]);

            $recall->setDescription($data_form['jobmanager_adminbundle_superrecall[description']);
            $recall->setRecruiter($recruiter);

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
} 