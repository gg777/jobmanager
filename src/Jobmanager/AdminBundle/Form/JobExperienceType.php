<?php

namespace Jobmanager\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JobExperienceType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titleJob', 'text', array('required' => false))
            ->add('companyName', 'text', array('required' => false))
            ->add('contractType', 'text', array('required' => false))
            ->add('dateBegin', 'date', array('required' => false))
            ->add('dateEnd', 'date', array('required' => false))
            ->add('description', 'textarea', array('required' => false))
            ->add('candidate', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Candidate',
                'property' => 'lastname',
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
            'data_class' => 'Jobmanager\AdminBundle\Entity\JobExperience'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jobmanager_adminbundle_jobexperience';
    }
}
