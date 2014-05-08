<?php


namespace Jobmanager\AdminBundle\Controller;


use Jobmanager\AdminBundle\Entity\Job;
use Jobmanager\AdminBundle\Form\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class JobController extends Controller
{
    public function addAction()
    {
        $job = new Job();

        $form = $this->createForm(new JobType, $job);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($job);
                $em->flush();

                $this->get('session')->getFlashBag()->add('infos', 'Poste ajouté.');

                return $this->redirect($this->generateUrl('admin_job_index', array(
                    'id' => $job->getId()
                )));
            }
        }

        return $this->render('JobmanagerAdminBundle:Job:add-job.html.twig', array(
            'form' => $form->createView()
        ));
    }
} 