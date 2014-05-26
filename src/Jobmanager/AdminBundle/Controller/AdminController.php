<?php


namespace Jobmanager\AdminBundle\Controller;

use Jobmanager\AdminBundle\Entity\CandidateJob;
use Jobmanager\AdminBundle\Entity\Company;
use Jobmanager\AdminBundle\Entity\Contact;
use Jobmanager\AdminBundle\Entity\Fonecall;
use Jobmanager\AdminBundle\Entity\Job;
use Jobmanager\AdminBundle\Entity\Meeting;
use Jobmanager\AdminBundle\Entity\Recruiter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jobmanager\AdminBundle\Entity\Jobs;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function indexAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve candidate_job
        $candidateJobs = $em->getRepository('JobmanagerAdminBundle:CandidateJob')
                            ->getActualCandidateJobs();

        // count candidate_job
        $countCandidateJobs = count($candidateJobs);

        foreach ($candidateJobs as &$candidateJob) {

            // check if each candidate_job has fonecall
            if ($em->getRepository('JobmanagerAdminBundle:Fonecall')->checkIfCandidateJobHasFonecall($candidateJob) === true) {

                $candidateJob->hasFonecall = true;
                //echo $candidateJob->hasFonecall.'</br>';
            } else {
                $candidateJob->hasFonecall = false;
            }

            // check if each candidate_job has meeting
            if ($em->getRepository('JobmanagerAdminBundle:Meeting')->checkIfCandidateJobHasMeeting($candidateJob) === true) {
                $candidateJob->hasMeeting = true;


                // retrieve meetings
                $meetings = $em->getRepository('JobmanagerAdminBundle:Meeting')->getMeetingsForCandidateJob($candidateJob);
                // check if meetings have tests
                foreach ($meetings as $meeting) {

                    // check if meeting job has techtests
                    if ($em->getRepository('JobmanagerAdminBundle:Techtest')->getTestsForMeeting($meeting) != null) {

                        // retrieve test for meeting
                        $techtests = $em->getRepository('JobmanagerAdminBundle:Techtest')->getTestsForMeeting($meeting);

                        // calculate mean note
                        $meanNote = $count = 0;
                        foreach ($techtests as $techtest) {
                            $count++;
                            $meanNote += $techtest->getNote();
                        }
                        $meanNote = $meanNote / $count;

                        $candidateJob->meanNote = $meanNote;

                    } else {
                        $candidateJob->meanNote = null;
                    }
//                    print "<pre>"; \Doctrine\Common\Util\Debug::dump($meeting); print "</pre>";
//                    die('coucou');
                }


            } else {
                $candidateJob->hasMeeting = false;
                $candidateJob->meanNote = null;
            }
        }
        unset($candidateJob);



        // retrieve new jobs
        $newJobs = $em->getRepository('JobmanagerAdminBundle:Job')
                      ->getNewJobs();

        // retrieve recalls
        $recalls = $em->getRepository('JobmanagerAdminBundle:Recall')
                      ->getNewRecallsRecruiterCompany();

//        print "<pre>"; \Doctrine\Common\Util\Debug::dump($recalls[0]->getRecruiter()); print "</pre>";
//        die('coucou');

        // send view
        return $this->render('JobmanagerAdminBundle:Admin:index.html.twig', array(
            'candidatejobs' => $candidateJobs,
            'countCandidateJobs' => $countCandidateJobs,
            'newjobs' => $newJobs,
            'recalls' => $recalls
        ));
    }

    public function getRemixjobsNewJobsAction()
    {
        // call jobImport service
        $jobImportService = $this->container->get('jobmanager_admin.jobimport');

        // call entity manager
        $em = $this->getDoctrine()->getManager();

        $jobs = $jobImportService->importRemixjobs($em);

        // send view
        return $this->render('JobmanagerAdminBundle:Admin:remixjobs-index.html.twig', array(
            'jobs' => $jobs
        ));

    }

    public function importJobsAction()
    {
        // call jobImport service
        $jobImportService = $this->container->get('jobmanager_admin.jobimport');

        // call entity manager
        $em = $this->getDoctrine()->getManager();

        $jobImportService->importRemixjobs($em);

        die('coucou');
    }

} 