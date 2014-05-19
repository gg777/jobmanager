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

        // retrieve last jobs
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

        // send view
        return $this->render('JobmanagerAdminBundle:Admin:index.html.twig', array(
            'candidatejobs' => $candidateJobs,
            'countCandidateJobs' => $countCandidateJobs
        ));
    }

    public function getRemixjobsNewJobsAction()
    {
        // retrieve jobs from api
        $json_datas = file_get_contents('https://remixjobs.com/api/jobs');
        $jobsImport = json_decode($json_datas);

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

        foreach ($jobsImport->jobs as $jobImport) {

            foreach ($sf2_occurences as $sf2_occurence) {

                // filter sf2 jobs
                if (strpos($jobImport->title, $sf2_occurence) > 0) {
                    $flagSfJob = true;
                }
//
            }



            //if (isset($flagSfJob) && $flagSfJob == true) var_dump($flagSfJob); echo '<br/>';
            if (isset($flagSfJob)) {

                if ($flagSfJob === true) {

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

                    // check if has contact
                    foreach ($arrayTag as $tag) {

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

//        print '<pre>'; print_r($outputArr); print '</pre>';
//        die('coucou');

        // send view
        return $this->render('JobmanagerAdminBundle:Admin:remixjobs-index.html.twig', array(
            'jobs' => $outputArr
        ));

    }

    public function updateDbAction()
    {
        // call entity manager
        $em = $this->getDoctrine()->getManager();

        // retrieve jobs entries
        $jobs_import = $em->getRepository('JobmanagerAdminBundle:Jobs')
                          ->findAll();

        // retrieve current candidate
        $candidate = $em->getRepository('JobmanagerAdminBundle:Candidate')
                        ->find(1);

//        print "<pre>"; \Doctrine\Common\Util\Debug::dump($candidate); print "</pre>";
//        die('coucou');

        // for each jobs entry split data and insert them on job and company table
        foreach ($jobs_import as $job_import) {

            // create new job
            $job = new Job();
            $job->setName($job_import->getPosition());
            $job->setCreatedDate($job_import->getDate());
            $job->setUrlJob($job_import->getUrlJob());


            // retrieve company by name
            $company = $em->getRepository('JobmanagerAdminBundle:Company')
                          ->findByName($job_import->getCompany());

            // check if company already exists
            if (empty($company)) {
                // company not exist
                // create company
                $company = new Company();
                $company->setName($job_import->getCompany());
                $company->setZip($job_import->getZip());
                $company->setCity($job_import->getCity());
                $company->setCountry('France');
                $company->setUrlCompany($job_import->getUrlCompany());

                // retrieve recruiter by name
                $recruiter = $em->getRepository('JobmanagerAdminBundle:Recruiter')
                                ->findByFirstName($job_import->getContactLastName());

                // check if company have empty recruiter
                if ($job_import->getContactFirstName() != null) {

                    // company has a recruiter
                    // check if company already have recruiter
                    if (empty($recruiter)) {

                        // no recruiter

                        echo 'no recruiter</br>';
                        // create recruiter
                        $recruiter = new Recruiter();
                        $recruiter->setGender($job_import->getContactGenre());
                        $recruiter->setFirstName($job_import->getContactFirstName());
                        $recruiter->setLastName($job_import->getContactLastName());
                        $recruiter->setTel($job_import->getTel());
                        $recruiter->setEmail($job_import->getEmail());
                        $em->persist($recruiter);

                        // attach recruiter company
                        $company->setRecruiter($recruiter);

                    }

                }

                // attach company to job
                $job->setCompany($company);

            }

            // check if job ist return as object or array
            if ($company instanceof Company) {
                $job->setCompany($company);
            } else {
                $job->setCompany($company[0]);
            }

            // persist job
            $em->persist($job);

            // flush
            $em->flush();

            // create new candidate_job
            $candidateJob = new CandidateJob();
            $candidateJob->setJob($job);
            $candidateJob->setCandidate($candidate);
            $candidateJob->setCreatedDate($job_import->getDate());
            $candidateJob->setInterest($job_import->getInterest());
            $candidateJob->setIsApplied(true);
            $candidateJob->setIsRejected($job_import->getOut());
            $candidateJob->setName($job_import->getPosition().' - '.$job_import->getCompany());

            // persist candidate_job
            $em->persist($candidateJob);



            // check if date meeting exist in import
            if ($job_import->getDateMeeting1() != null) {
                // if yes attach to meeting a candidate_job with answer
                // create a new meeting
                $meeting = new Meeting();
                $meeting->setCandidateJob($candidateJob);
                $meeting->setDateBegin($job_import->getDateMeeting1());
                $meeting->setDescription($job_import->getAnswer());
//                print "<pre>"; \Doctrine\Common\Util\Debug::dump($job_import->getDateMeeting1()->format('Y-m-d H:i:s')); print "</pre>";
//                die('coucou');
                $meeting->setName($job_import->getDateMeeting1()->format('Y-m-d H:i:s').' - '.$job_import->getCompany());

                // persist
                $em->persist($meeting);
            }

            // check if date answer exist in import

            if ($job_import->getDateAnswer() != null) {
                // if yes attach to fonecall a candidate_job with answer and contact inbound
                // create a new fonecall
                $fonecall = new Fonecall();
                $fonecall->setCandidateJob($candidateJob);
                $fonecall->setDateBegin($job_import->getDateAnswer());
                $fonecall->setDescription($job_import->getAnswer());
                $fonecall->setIsInbound($job_import->getContactInbound());
                $fonecall->setSource($job_import->getSource());

                // persist
                $em->persist($fonecall);
            }

            // flush
            $em->flush();

        }

        // todo finir la vue
        die('coucou');


        // send view
        return $this->render('JobmanagerAdminBundle:Admin:index.html.twig');
    }

} 