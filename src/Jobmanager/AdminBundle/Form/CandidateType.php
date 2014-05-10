<?php

namespace Jobmanager\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CandidateType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', 'text')
            ->add('firstname', 'text')
            ->add('lastname', 'text')
            ->add('tel', 'text')
            ->add('email', 'text')
            ->add('address' , 'textarea')
            ->add('zip', 'text')
            ->add('city', 'text')
            ->add('birthdate', 'date')
            ->add('createdDate', 'date')
            ->add('competences', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Competence',
                'property' => 'name',
                'multiple' => true
            ))
            ->add('languages', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Language',
                'property' => 'name',
                'multiple' => true
            ))
            ->add('diplomas', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Diploma',
                'property' => 'name',
                'multiple' => true
            ))
            ->add('formations', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Formation',
                'property' => 'name',
                'multiple' => true
            ))
            ->add('cvs', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Cv',
                'property' => 'name',
                'multiple' => true
            ))
            ->add('motivations', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Motivation',
                'property' => 'name',
                'multiple' => true
            ))
            ->add('jobExperiences', 'entity', array(
                'class' => 'JobmanagerAdminBundle:JobExperience',
                'property' => 'company_name',
                'multiple' => true
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jobmanager\AdminBundle\Entity\Candidate'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jobmanager_adminbundle_candidate';
    }
}
