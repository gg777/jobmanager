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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Jobmanager\AdminBundle\Entity\Job;
use Jobmanager\AdminBundle\Form\JobType;

class SuperJobController extends Controller
{
    public function createAction()
    {
        // new job
        $job = new Job();

        // generate form
        $form = $this->createForm(new JobType, $job);

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

        // if no post
        return $this->render('JobmanagerAdminBundle:Job:create-edit-job.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function createNewCompanyAction()
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

            //$renderedTmpl->getContent();


//            print "<pre>"; \Doctrine\Common\Util\Debug::dump($viewForm); print "</pre>";
//            die;

            // send response
            $response = new JsonResponse();
            $response->setData(array('form_data' => $renderedTmpl));
            return $response;



        }
    }
} 