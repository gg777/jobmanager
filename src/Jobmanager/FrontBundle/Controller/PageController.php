<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 23/05/2014
 * Time: 22:39
 */

namespace Jobmanager\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $candidate = $em->getRepository('JobmanagerAdminBundle:Candidate')
                        ->find(1);

        $motivation = $em->getRepository('JobmanagerAdminBundle:Motivation')
                         ->getLastMotivationFromCandidate(1);

//        print "<pre>"; \Doctrine\Common\Util\Debug::dump($motivation[0]); print "</pre>";
//        die('coucou');

        return $this->render('JobmanagerFrontBundle:Page:index.html.twig', array(
            'candidate' => $candidate,
            'motivation' => $motivation[0]
        ));
    }
} 