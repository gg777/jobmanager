<?php

namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Entity\Job;
use Jobmanager\AdminBundle\Entity\Company;
use Jobmanager\AdminBundle\Entity\Recruiter;
use Jobmanager\AdminBundle\Form\CompanyType;
use Jobmanager\AdminBundle\Form\RecruiterSuperJobType;
use Jobmanager\AdminBundle\Form\SuperJobType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class SuperJobController extends Controller
{
    /**
     * Create new job
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        // create new job
        $job = new Job();

        // build form
        $form = $this->createForm(new SuperJobType, $job);

        // get request
        $request = $this->get('request');

        // check if post sent
        if ($request->getMethod() == 'POST') {

            // bind data form
            $form->handleRequest($request);

            // validate data
            if ($form->isValid()) {

                // call entity manager
                $em = $this->getDoctrine()->getManager();

                // save in db
                $em->persist($job);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Nouvelle annonce enregistrée');

                // redirect
                return $this->redirect($this->generateUrl('admin_job_index'));
            }

        }

        // if no post
        return $this->render('JobmanagerAdminBundle:SuperJob:create-edit-superjob.html.twig', array(
            'form' => $form->createView()
        ));
    }



    /**
     * Create new company form
     * @return JsonResponse
     */
    public function createNewCompanyFormAction()
    {
        // get request
        $request = $this->get('request');

        // check if ajax request
        if ($request->isXmlHttpRequest()) {

            // create new company form
            $company = new Company();
            $companyForm = new CompanyType();

            // build form
            $renderedTmpl = $this->buildEntityForm($company, $companyForm, 'job');

            // send response
            $response = new JsonResponse();
            $response->setData(array(
                'form_data' => $renderedTmpl
            ));
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

        // check if ajax sent
        if ($request->isXmlHttpRequest()) {

            // get form data
            $dataForm = $request->request->get('data_form');

            // call service formToEntity
            $formToEntity = $this->container->get('jobmanager_admin.form_to_entity');

            // create new company
            $company = $formToEntity->createCompany($dataForm);

            // create new job
            $job = $formToEntity->createJob($dataForm, $company);

            // call entity manager
            $em = $this->getDoctrine()->getManager();

            // save in db
            $em->persist($company);
            $em->persist($job);
            $em->flush();

            // send response
            $response = new JsonResponse();
            $response->setData(array('view' => $this->redirect($this->generateUrl('JobmanagerAdminBundle_homepage'))));
            return $response;
        }
    }

    /**
     * Create new recruiter form
     * @return JsonResponse
     */
    public function createNewRecruiterFormAction()
    {
        // get request
        $request = $this->get('request');

        // check ajax request
        if ($request->isXmlHttpRequest()) {

            // create new recruiter form
            $recruiter = new Recruiter();
            $recruiterForm = new RecruiterSuperJobType();

            // build form
            $renderedTmpl = $this->buildEntityForm($recruiter, $recruiterForm, 'job');

            // send response
            $response = new JsonResponse();
            $response->setData(array(
                'form_data' => $renderedTmpl
            ));
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

        // check if ajax sent
        if ($request->isXmlHttpRequest()) {

            // get form data
            $dataForm = $request->request->get('data_form');

            // call service formToEntity
            $formToEntity = $this->container->get('jobmanager_admin.form_to_entity');

            // create new company
            $company = $formToEntity->createCompany($dataForm);

            // create new recruiter
            $recruiter = $formToEntity->createRecruiter($dataForm, $company);

            // create new job
            $job = $formToEntity->createJob($dataForm, $company);

            // call entity manager
            $em = $this->getDoctrine()->getManager();

            // save in db
            $em->persist($company);
            $em->persist($recruiter);
            $em->persist($job);
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