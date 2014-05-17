<?php
    /**
     * Created by PhpStorm.
     * User: gerard
     * Date: 09/05/2014
     * Time: 21:35
     */

namespace Jobmanager\AdminBundle\Controller;

    use Jobmanager\AdminBundle\Form\RecruiterEditType;
    use Jobmanager\AdminBundle\Form\RecruiterType;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Response;
    use Jobmanager\AdminBundle\Entity\Recruiter;

class RecruiterController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve recruiters
        $recruiters = $em->getRepository('JobmanagerAdminBundle:Recruiter')
                         ->getRecruitersByIdInv();

        // send view
        return $this->render('JobmanagerAdminBundle:Recruiter:index.html.twig', array(
            'recruiters' => $recruiters
        ));
    }


    public function createAction()
    {
        // new recruiter
        $recruiter = new Recruiter();

        // generate form
        $form = $this->createForm(new RecruiterType, $recruiter);

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
                $em->persist($recruiter);
                $em->flush();

                // send message
                $this->get('session')->getFlashBag()->add('notice', 'Contact bien enregistré');

                // redirect
                return $this->redirect($this->generateUrl('admin_recruiter_index'));

            }

        }

        // if no post
        return $this->render('JobmanagerAdminBundle:Recruiter:create-edit-recruiter.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function viewAction(Recruiter $recruiter)
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // send view
        return $this->render('JobmanagerAdminBundle:Recruiter:view.html.twig', array(
            'recruiter' => $recruiter
        ));
    }

    public function editAction(Recruiter $recruiter)
    {
        // generate form
        $form = $this->createForm(new RecruiterEditType, $recruiter);

        // get request
        $request = $this->get('request');

        // check if post sent
        if ($request->getMethod() == 'POST') {

            // bind data form
            $form->handleRequest($request);

            // valid data
            if ($form->isValid()) {

                // call entity manager
                $em = $this->getDoctrine()->getManager();

                // persist and flush
                $em->persist($recruiter);
                $em->flush();

                // send flas message
                $this->get('session')->getFlashBag()->add('info', 'Contact modifié');

                // redirect
                return $this->redirect($this->generateUrl('admin_recruiter_index'));

            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Recruiter:create-edit-recruiter.html.twig', array(
            'form' => $form->createView(),
            'recruiter' => $recruiter
        ));
    }

    public function deleteAction(Recruiter $recruiter)
    {
        // create empty form against csrf
        $form = $this->createFormBuilder()->getForm();

        // get request
        $request = $this->get('request');

        // check if post sent
        if ($request->getMethod() == 'POST') {

            // bind data form
            $form->handleRequest($request);

            // valide data
            if ($form->isValid()) {

                // call entity manager
                $em = $this->getDoctrine()->getManager();

                // remove recruiter
                $em->remove($recruiter);
                $em->flush();

                // send flash message
                $this->get('session')->getFlashBag()->add('info', 'Contact supprimé.');

                // redirect
                return $this->redirect($this->generateUrl('admin_recruiter_index'));
            }
        }

        // send view
        return $this->render('JobmanagerAdminBundle:Recruiter:delete.html.twig', array(
            'form' => $form->createView(),
            'recruiter' => $recruiter
        ));
    }
}