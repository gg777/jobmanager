<?php

namespace Jobmanager\AdminBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CandidateJobEditType extends AbstractType
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
            ->add('candidate', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Candidate',
                'property' => 'lastname'
            ))
            ->add('job', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Job',
                'property' => 'name'
            ))
        ;
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
        return 'jobmanager_adminbundle_candidatejob_edit';
    }
}
