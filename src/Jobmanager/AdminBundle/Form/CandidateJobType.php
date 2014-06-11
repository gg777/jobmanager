<?php

namespace Jobmanager\AdminBundle\Form;

use Doctrine\ORM\EntityManager;
use Jobmanager\AdminBundle\Entity\JobRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CandidateJobType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createdDate', 'date')
            ->add('interest', 'textarea', array(
                'required' => false
            ))
            ->add('isRejected', 'checkbox', array(
                'required' => false
            ))
            ->add('isOutdated', 'checkbox', array(
                'required' => false
            ))
            ->add('job', 'choice', array(
                'choices' => $this->buildJobName()
            ))
            ->add('candidate', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Candidate',
                'property' => 'lastname'
            ))
        ;
    }

    private function buildJobName()
    {
        $choices = array();

        $jobs = $this->entityManager
                      ->getRepository('JobmanagerAdminBundle:Job')
                      ->createQueryBuilder('j')
                      ->addSelect('j')
                      ->distinct('j')
                      ->leftJoin('j.company', 'c')
                      ->addSelect('c')
                      ->where('j.isApplied = :isApplied')
                      ->setParameter('isApplied', 0)
                      ->andWhere('j.isNoInterest = :isNoInterest')
                      ->setParameter('isNoInterest', 0)
                      ->orderBy('j.createdDate', 'DESC')
                      ->getQuery()
                      ->getResult();

        foreach ($jobs as $job)
            $choices[$job->getId()] = $job->getName().' - '.$job->getCompany()->getName();

        return $choices;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jobmanager\AdminBundle\Entity\CandidateJob'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jobmanager_adminbundle_candidatejob';
    }
}
