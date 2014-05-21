<?php

namespace Jobmanager\AdminBundle\Form;

use Jobmanager\AdminBundle\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JobType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createdDate', 'date', array('required' => false))
            ->add('name', 'text', array('required' => false))
            ->add('urlJob', 'text', array('required' => false))
            ->add('remixjobs_id', 'text', array('required' => false))
            ->add('contract_type', 'text', array('required' => false))
            ->add('isApplied', 'checkbox', array('required' => false))
            ->add('is_soldout', 'checkbox', array('required' => false))
            ->add('company', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Company',
                'property' => 'name',
                'empty_value' => 'Choose Company',
                'required' => false,
                'empty_data' => null
            ))
            ->add('postingJob', 'textarea', array(
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
            'data_class' => 'Jobmanager\AdminBundle\Entity\Job'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jobmanager_adminbundle_job';
    }
}
