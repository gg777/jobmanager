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
            ->add('gender', 'text', array('required' => false))
            ->add('firstname', 'text', array('required' => false))
            ->add('lastname', 'text', array('required' => false))
            ->add('tel', 'text', array('required' => false))
            ->add('email', 'text', array('required' => false))
            ->add('address' , 'textarea', array('required' => false))
            ->add('zip', 'text', array('required' => false))
            ->add('city', 'text', array('required' => false))
            ->add('birthdate', 'date', array('required' => false))
            ->add('createdDate', 'date', array('required' => false))
            ->add('competences', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Competence',
                'property' => 'name',
                'required' => false
            ))
            ->add('languages', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Language',
                'property' => 'name',
                'required' => false
            ))
            ->add('diplomas', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Diploma',
                'property' => 'name',
                'required' => false
            ))
            ->add('formations', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Formation',
                'property' => 'name',
                'required' => false
            ))
            ->add('cvs', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Cv',
                'property' => 'name',
                'required' => false
            ))
            ->add('motivations', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Motivation',
                'property' => 'name',
                'required' => false
            ))
            ->add('jobExperiences', 'entity', array(
                'class' => 'JobmanagerAdminBundle:JobExperience',
                'property' => 'company_name',
                'required' => false
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
