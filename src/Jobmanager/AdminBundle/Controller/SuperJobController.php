<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 11/05/2014
 * Time: 17:37
 */

namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Entity\Company;
use Jobmanager\AdminBundle\Form\CompanyType;
use Jobmanager\AdminBundle\Form\SuperJobType;
use Jobmanager\AdminBundle\Form\SuperJobEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Jobmanager\AdminBundle\Entity\Job;
use Jobmanager\AdminBundle\Form\JobType;
use Jobmanager\AdminBundle\Form\JobEditType;
use Jobmanager\AdminBundle\Entity\Recruiter;
use Jobmanager\AdminBundle\Form\RecruiterType;
use Jobmanager\AdminBundle\Form\RecruiterEditType;

class SuperJobController extends Controller
{
    public function createAction()
    {
        // new job
        $job = new Job();

        // generate form
        $form = $this->createForm(new SuperJobType, $job);

        // get request
        $request = $this->get('request');

        // check if post sent
        if ($request->getMethod() == 'POST') {

            // bind data form
            $form->handleRequest($request);

            // valid form
            if ($form->isValid()) {

//                print "<pre>"; \Doctrine\Common\Util\Debug::dump($job); print "</pre>";
//                die;

                // save in db
                $em = $this->getDoctrine()->getManager();
                $em->persist($job);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Poste bien enregistré');

                // redirect
                return $this->redirect($this->generateUrl('admin_job_index'));

            }

        }

        // send view
        return $this->render('JobmanagerAdminBundle:Job:create-edit-job.html.twig', array(
            'form' => $form->createView()
        ));

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


            $renderedTmpl = $this->container->get('templating')->render('JobmanagerAdminBundle:Company:create-edit-company-ajax.html.twig', array(
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

            // retrieve recruiter by lastname
            $em = $this->getDoctrine()->getManager();
            $recruiter = $em->getRepository('JobmanagerAdminBundle:Recruiter')
                            ->find($data_form['company']['recruiter']);

//            print "<pre>"; \Doctrine\Common\Util\Debug::dump($recruiter); print "</pre>";
//            die;

            $company->setRecruiter($recruiter);

            // create new job
            $job = new Job();

            // bind data
            $job->setName($data_form['job']['name']);
            $job->setUrlJob($data_form['job']['urlJob']);
            $job->setRemixjobsId($data_form['job']['remixjobsId']);
            $job->setContractType($data_form['job']['contractType']);
            $job->setCreatedDate(new \DateTime());
            $job->setCompany($company);

            // save db
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            die('coucou');

            // redirect create action with parameter company id


        }
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


            $renderedTmpl = $this->container->get('templating')->render('JobmanagerAdminBundle:Recruiter:create-edit-recruiter-ajax.html.twig', array(
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

            // get ajax post data
            $data_form = $request->request->get('data_form');
//
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
            $company->setRecruiter($recruiter);

            // create new job
            $job = new Job();

            // bind data
            $job->setName($data_form['job']['name']);
            $job->setUrlJob($data_form['job']['urlJob']);
            $job->setRemixjobsId($data_form['job']['remixjobsId']);
            $job->setContractType($data_form['job']['contractType']);
            $job->setCreatedDate(new \DateTime());
            $job->setCompany($company);

            // save db
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            die('coucou');

            // redirect create action with parameter company id


        }
    }
} 