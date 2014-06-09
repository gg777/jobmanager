<?php

namespace Jobmanager\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SuperJobType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'required' => false
            ))
            ->add('urlJob', 'text', array(
                'required' => false
            ))
            ->add('remixjobs_id', 'text', array(
                'required' => false
            ))
            ->add('contract_type', 'text', array(
                'required' => false
            ))
            ->add('job_source', 'entity', array(
                'class' => 'JobmanagerAdminBundle:JobSource',
                'property' => 'name',
                'empty_value' => 'Choose job source',
                'required' => false,
                'empty_data' => null
            ))
            ->add('posting_job', 'textarea', array(
                'required' => false
            ))
            ->add('company', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Company',
                'property' => 'name',
                'empty_value' => 'Choose Company',
                'required' => false,
                'empty_data' => null
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jobmanager\AdminBundle\Entity\Job'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jobmanager_adminbundle_superjob';
    }
}
