<?php

namespace Jobmanager\AdminBundle\Form;

use Jobmanager\AdminBundle\Entity\Company;
use Jobmanager\AdminBundle\Form\CompanyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecruiterFrontType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', 'choice', array(
                'choices' => array(
                    'mr' => 'Mr',
                    'mme' => 'Mme'
                ),
                'label' => '* Civilité :'
            ))
            ->add('firstName', 'text', array(
                'label' => '* Prénom :',
                'required' => true
            ))
            ->add('lastName', 'text', array(
                'label' => '* Nom :',
                'required' => true
            ))
            ->add('tel', 'text', array(
                'label' => 'Tel. :',
                'required' => false
            ))
            ->add('mobile', 'text', array(
                'label' => 'Mobile :',
                'required' => false
            ))
            ->add('email', 'text', array(
                'label' => '* Email :',
                'required' => false))
            ->add('company', new CompanyFrontType(), array(
                'label' => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jobmanager\AdminBundle\Entity\Recruiter'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jobmanager_adminbundle_recruiter';
    }
}
