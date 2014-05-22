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

//        print "<pre>"; \Doctrine\Common\Util\Debug::dump($candidateJob); print "</pre>";
//        die('coucou');

        // retrieve new jobs
        $newJobs = $em->getRepository('JobmanagerAdminBundle:Job')
                      ->getNewJobs();

        // retrive recalls
        $recalls = $em->getRepository('JobmanagerAdminBundle:Recall')
                      ->getNewRecalls();

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
        // retrieve jobs from api
        $json_datas = file_get_contents('https://remixjobs.com/api/jobs');
        $jobsImport = json_decode($json_datas);

        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // set output array
        $outputArr = array();

        // set filter sf2 jobs
        $sf2_occurences = array(
            'Symfony',
            'symfony',
            'Symfony 2',
            'Symfony2',
            'symfony 2',
            'symfony2',
            'sf2',
            'SF2'
        );

        // for each job ...
        foreach ($jobsImport->jobs as $jobImport) {



            // check if job already imported
            if ($em->getRepository('JobmanagerAdminBundle:Job')->getJobByRemixjobsId($jobImport->id) == null) {

                // check if title contain sf2 occurences
                foreach ($sf2_occurences as $sf2_occurence) {

                    // filter sf2 jobs
                    if (strpos($jobImport->title, $sf2_occurence) > 0) {
                        $flagSfJob = true;

                    }

                }

                // check protect
                if (isset($flagSfJob)) {

                    // if not imported do a new one
                    if ($flagSfJob === true) {
//                        print '<pre>'; print_r($jobImport->title); print '</pre>';
                        // unset flag
                        $flagSfJob = false;

                        // Recruiter
                        // parse postingJob to find recruiter contact
                        $description = $jobImport->description;

                        // instanciate new DOMDocument to parse HTML by tags as node
                        $dom = new \DOMDocument();
                        $dom->loadHTML($description);
                        foreach ($dom->getElementsByTagName('p') as $node) {

                            $arrayTag[] = $dom->saveHTML($node);

                        }


                        foreach ($arrayTag as $tag) {

                            // check posting job if has contact inside and create and hydrate the recruiter object
                            if (strpos($tag, 'Contact') == true) {

                                // parse contact
                                $contactArr = explode(' ', $tag);

                                $recruiter = new Recruiter();
                                $recruiter->setFirstName($contactArr[2]);
                                $recruiter->setLastName($contactArr[3]);

                                // check email string and clean
                                $email = str_replace('(', '', $contactArr[4]);
                                $email = str_replace(')', '', $email);
                                $recruiter->setEmail($email);

                                // reconstruct tel
                                $tel = $contactArr[6].' '.$contactArr[7].' '.$contactArr[8].' '.$contactArr[9].' '.$contactArr[10];

                                // check if is mobile tel
                                if ($contactArr[6] == 06) {
                                    $recruiter->setMobile($tel);
                                } else {
                                    $recruiter->setTel($tel);
                                }

                                //var_dump($recruiter); die;
                                $flagRecruiter = true;

                            } else {
                                $flagRecruiter = false;
                            }

                        }

                        // Company
                        $company = new Company();
                        $company->setName($jobImport->company_name);

                        if (isset($jobImport->company_website))
                            $company->setUrlCompany($jobImport->company_website);

                        // parse address
                        $addressArr = explode(',', $jobImport->geolocation->formatted_address);

                        $cityArr = explode(' ', $addressArr[1]);

                        $company->setAddress($addressArr[0]);
                        $company->setZip($cityArr[1]);
                        //$company->setCity($cityArr[2]);
                        //$company->setCountry($addressArr[2]);
                        $company->setLat($jobImport->geolocation->lat);
                        $company->setLng($jobImport->geolocation->lng);

                        if ($flagRecruiter == true) {
                            $company->setRecruiter($recruiter);
                        }


                        // Job
                        $job = new Job();
                        $job->setCreatedDate($jobImport->validation_time);
                        $job->setRemixjobsId($jobImport->id);
                        $job->setName($jobImport->title);
                        $job->setContractType($jobImport->contract_type);
                        $job->statusRemixjobs = $jobImport->status;
                        $job->setUrlJob($jobImport->_links->www->href);
                        $job->setCompany($company);
                        $job->setPostingJob($jobImport->description);

                        $outputArr[] = $job;

                    }

                }

            }

        }

//        print '<pre>'; print_r($outputArr); print '</pre>';
//        die('coucou');

        // send view
        return $this->render('JobmanagerAdminBundle:Admin:remixjobs-index.html.twig', array(
            'jobs' => $outputArr
        ));

    }

} 