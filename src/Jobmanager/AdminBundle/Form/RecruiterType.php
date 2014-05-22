<?php

namespace Jobmanager\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecruiterType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', 'text', array('required' => false))
            ->add('firstName', 'text', array('required' => false))
            ->add('lastName', 'text', array('required' => false))
            ->add('tel', 'text', array('required' => false))
            ->add('mobile', 'text', array('required' => false))
            ->add('email', 'text', array('required' => false))
            ->add('company', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Company',
                'property' => 'name',
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
