<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 23/05/2014
 * Time: 22:39
 */

namespace Jobmanager\FrontBundle\Controller;

use Jobmanager\AdminBundle\Entity\Recall;
use Jobmanager\AdminBundle\Form\SuperRecallFrontType;
use Jobmanager\AdminBundle\Form\SuperRecallType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

class PageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $candidate = $em->getRepository('JobmanagerAdminBundle:Candidate')
                        ->find(1);

        $motivation = $em->getRepository('JobmanagerAdminBundle:Motivation')
                         ->getLastMotivationFromCandidate(1);


        $recall = new Recall();
        $form = $this->createForm(new SuperRecallFrontType, $recall);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

//            print "<pre>"; \Doctrine\Common\Util\Debug::dump($form->getData()); print "</pre>";
//            die('coucou');

            if ($form->isValid()) {

                $recall->setCreatedDate(new \DateTime());
                $recall->setIsFirstContact(1);
                $recall->setIsRecalled(0);

                $em->persist($recall);
                $em->flush();

                $this->get('session')->getFlashBag()->add('infos', 'Message envoyé.');

                $this->redirect($this->generateUrl('JobmanagerFrontBundle_homepage'));

            }

        }


        return $this->render('JobmanagerFrontBundle:Page:index.html.twig', array(
            'candidate' => $candidate,
            'motivation' => $motivation[0],
            'form' => $form->createView(),
        ));
    }
} 