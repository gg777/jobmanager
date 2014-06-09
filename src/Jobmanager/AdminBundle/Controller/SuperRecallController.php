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

    /**
     * Create recruiter form
     * @return JsonResponse
     */
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

            // call formToEntity service
            $fromToEntity = $this->container->get('jobmanager_admin.form_to_entity');

            // create new recruiter
            $recruiter = $fromToEntity->createRecruiter($dataForm, $company);

            // create new recall
            $recall = $fromToEntity->createRecall($em, $dataForm, $recruiter);

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

    /**
     * Create company form
     * @return JsonResponse
     */
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

    /**
     * Create new company
     * @return JsonResponse
     */
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

            // call formToEntity service
            $fromToEntity = $this->container->get('jobmanager_admin.form_to_entity');

            // create new company
            $company = $fromToEntity->createCompany($dataForm);

            // create new recruiter
            $recruiter = $fromToEntity->createRecruiter($dataForm, $company);

            // create new recall
            $recall = $fromToEntity->createRecall($em, $dataForm, $recruiter);

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

} 