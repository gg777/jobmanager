<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 11/05/2014
 * Time: 17:37
 */

namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Entity\Job;
use Jobmanager\AdminBundle\Entity\Recruiter;
use Jobmanager\AdminBundle\Form\CompanyType;
use Jobmanager\AdminBundle\Form\RecruiterSuperJobType;
use Jobmanager\AdminBundle\Form\SuperJobType;
use Jobmanager\AdminBundle\Entity\Company;
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
            $data_form = $request->request->get('data_form');

            // create new company
            $company = new Company();
            $company->setName($data_form['jobmanager_adminbundle_superjob[name']);

            $company->setType($data_form['jobmanager_adminbundle_company[type']);
            $company->setSector($data_form['jobmanager_adminbundle_company[sector']);
            $company->setAddress($data_form['jobmanager_adminbundle_company[address']);
            $company->setZip($data_form['jobmanager_adminbundle_company[zip']);
            $company->setCity($data_form['jobmanager_adminbundle_company[city']);
            $company->setCountry($data_form['jobmanager_adminbundle_company[country']);
            $company->setLat($data_form['jobmanager_adminbundle_company[lat']);
            $company->setLng($data_form['jobmanager_adminbundle_company[lng']);
            $company->setIsHeadHunter($data_form['jobmanager_adminbundle_company[is_head_hunter']);

            // create new job
            $job = new Job();
            $job->setCreatedDate(new \DateTime());
            $job->setCompany($company);
            $job->setName($data_form['jobmanager_adminbundle_superjob[name']);
            $job->setUrlJob($data_form['jobmanager_adminbundle_superjob[urlJob']);
            $job->setRemixjobsId($data_form['jobmanager_adminbundle_superjob[remixjobs_id']);
            $job->setContractType($data_form['jobmanager_adminbundle_superjob[contract_type']);
            $job->setPostingJob($data_form['jobmanager_adminbundle_superjob[posting_job']);
            $job->setIsApplied(0);
            $job->setIsSoldout(0);

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
            $data_form = $request->request->get('data_form');

            // create new company
            $company = new Company();
            $company->setName($data_form['jobmanager_adminbundle_superjob[name']);

            $company->setType($data_form['jobmanager_adminbundle_company[type']);
            $company->setSector($data_form['jobmanager_adminbundle_company[sector']);
            $company->setAddress($data_form['jobmanager_adminbundle_company[address']);
            $company->setZip($data_form['jobmanager_adminbundle_company[zip']);
            $company->setCity($data_form['jobmanager_adminbundle_company[city']);
            $company->setCountry($data_form['jobmanager_adminbundle_company[country']);
            $company->setLat($data_form['jobmanager_adminbundle_company[lat']);
            $company->setLng($data_form['jobmanager_adminbundle_company[lng']);
            $company->setIsHeadHunter($data_form['jobmanager_adminbundle_company[is_head_hunter']);

            // create new recruiter
            $recruiter = new Recruiter();
            $recruiter->setCompany($company);
            $recruiter->setGender($data_form['jobmanager_adminbundle_recruiter[gender']);
            $recruiter->setFirstName($data_form['jobmanager_adminbundle_recruiter[firstName']);
            $recruiter->setLastName($data_form['jobmanager_adminbundle_recruiter[lastName']);
            $recruiter->setTel($data_form['jobmanager_adminbundle_recruiter[tel']);
            $recruiter->setMobile($data_form['jobmanager_adminbundle_recruiter[mobile']);
            $recruiter->setEmail($data_form['jobmanager_adminbundle_recruiter[email']);

            // create new job
            $job = new Job();
            $job->setCreatedDate(new \DateTime());
            $job->setCompany($company);
            $job->setName($data_form['jobmanager_adminbundle_superjob[name']);
            $job->setUrlJob($data_form['jobmanager_adminbundle_superjob[urlJob']);
            $job->setRemixjobsId($data_form['jobmanager_adminbundle_superjob[remixjobs_id']);
            $job->setContractType($data_form['jobmanager_adminbundle_superjob[contract_type']);
            $job->setPostingJob($data_form['jobmanager_adminbundle_superjob[posting_job']);
            $job->setIsApplied(0);
            $job->setIsSoldout(0);

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
} 