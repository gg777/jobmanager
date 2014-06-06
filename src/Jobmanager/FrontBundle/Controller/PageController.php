<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 23/05/2014
 * Time: 22:39
 */

namespace Jobmanager\FrontBundle\Controller;

use Jobmanager\AdminBundle\Entity\Job;
use Jobmanager\AdminBundle\Entity\Company;
use Jobmanager\AdminBundle\Entity\Recruiter;
use Jobmanager\AdminBundle\Entity\Recall;
use Jobmanager\AdminBundle\Form\SuperJobFrontType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class PageController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve candidate
        $candidate = $em->getRepository('JobmanagerAdminBundle:Candidate')
                        ->find(1);

        // retrieve candidate motivation
        $motivation = $em->getRepository('JobmanagerAdminBundle:Motivation')
                         ->getLastMotivationFromCandidate(1);

        // create new job
        $job = new Job();

        $form = $this->createForm(new SuperJobFrontType, $job);

        return $this->render('JobmanagerFrontBundle:Page:index.html.twig', array(
            'candidate' => $candidate,
            'motivation' => $motivation[0],
            'form' => $form->createView(),
        ));
    }

    public function submitJobFormAction()
    {

        /**
         * check if mail is valid
         * @param $email
         * @return bool
         */
        function emailIsValid($email) {
            if (preg_match('`^[[:alnum:]]([-_.]?[[:alnum:]])+_?@[[:alnum:]]([-.]?[[:alnum:]])+\.[a-z]{2,4}$`',$email)) {
                return true;
            } else {
                return false;
            }
        }

        // get request
        $request = $this->container->get('request');

        // check if ajax request
        if ($request->isXmlHttpRequest()) {

            // call entity manager
            $em = $this->getDoctrine()->getManager();

            // get ajax post data
            $data_form = $request->request->get('data');

            // validate datas
            $msg = '';
            $error = 0;

            // validate company
            if (empty($data_form['jobmanager_frontbundle_jobfront[company']['name'])) {
                $msg .= 'Champs entreprise obligatoire<br/>';
                $error++;
            }

            if (empty($data_form['jobmanager_frontbundle_jobfront[company']['address'])) {
                $msg .= 'Champs adresse obligatoire<br/>';
                $error++;
            }

            if (empty($data_form['jobmanager_frontbundle_jobfront[company']['zip'])) {
                $msg .= 'Champs code postal obligatoire<br/>';
                $error++;
            }

            if (empty($data_form['jobmanager_frontbundle_jobfront[company']['city'])) {
                $msg .= 'Champs ville obligatoire<br/>';
                $error++;
            }

            // validate job
            if (empty($data_form['jobmanager_frontbundle_jobfront[name'])) {
                $msg .= 'Champs titre du poste obligatoire<br/>';
                $error++;
            }

            if (empty($data_form['jobmanager_frontbundle_jobfront[contract_type'])) {
                $msg .= 'Champs type de contrat obligatoire<br/>';
                $error++;
            }

            if (empty($data_form['jobmanager_frontbundle_jobfront[postingJob'])) {
                $msg .= 'Champs descriptif de poste obligatoire<br/>';
                $error++;
            }

            // validate recruiter
            if (empty($data_form['firstname'])) {
                $msg .= 'Champs prénom obligatoire<br/>';
                $error++;
            }

            if (empty($data_form['lastname'])) {
                $msg .= 'Champs nom obligatoire<br/>';
                $error++;
            }

            if (empty($data_form['tel'])) {
                $msg .= 'Champs tel. obligatoire<br/>';
                $error++;
            }

            if (empty($data_form['email'])) {
                $msg .= 'Champs email obligatoire<br/>';
                $error++;
            }

            if (!emailIsValid($data_form['email'])){
                $error++;
                $msg .= "Indiquez un mail valide<br />";
            }


            // check captcha
            if(md5($data_form['code_antispam']) != $_SESSION["code_antispam"]) {
                $error++;
                $msg .= "Indiquez le code anti-spam correct<br />";
            }


            //print '<pre>'; print_r($_SESSION["code_antispam"]); print '</pre>';

            // check if form is valid
            if ($error == 0) {

                // create new company
                $company = new Company();

                // bind data
                $company->setName($data_form['jobmanager_frontbundle_jobfront[company']['name']);
                $company->setAddress($data_form['jobmanager_frontbundle_jobfront[company']['address']);
                $company->setZip($data_form['jobmanager_frontbundle_jobfront[company']['zip']);
                $company->setCity($data_form['jobmanager_frontbundle_jobfront[company']['city']);
                $company->setUrlCompany($data_form['jobmanager_frontbundle_jobfront[company']['urlCompany']);

                // create new job
                $job = new Job();

                // bind data
                $job->setCompany($company);
                $job->setName($data_form['jobmanager_frontbundle_jobfront[name']);
                $job->setContractType($data_form['jobmanager_frontbundle_jobfront[contract_type']);
                $job->setPostingJob($data_form['jobmanager_frontbundle_jobfront[postingJob']);
                $job->setIsApplied(0);

                // create new recruiter
                $recruiter = new Recruiter();

                // bind data
                $recruiter->setGender($data_form['gender']);
                $recruiter->setFirstName($data_form['firstname']);
                $recruiter->setLastName($data_form['lastname']);
                $recruiter->setTel($data_form['tel']);
                $recruiter->setMobile($data_form['mobile']);
                $recruiter->setEmail($data_form['email']);
                $recruiter->setCompany($company);

                // create new recall
                $recall = new Recall();

                // bind data
                $recall->setCreatedDate(new \DateTime());
                $recall->setIsFirstContact(1);
                $recall->setIsRecalled(0);
                $recall->setRecruiter($recruiter);

                // save db
                $em->persist($company);
                $em->persist($job);
                $em->persist($recruiter);
                $em->persist($recall);
                $em->flush();

                // send response
                $response = new JsonResponse('Message bien envoyé');
                return $response;

            } else {

                // send response
                $response = new JsonResponse($msg);
                return $response;

            }

        }
    }
} 