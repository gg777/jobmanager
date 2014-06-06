<?php

namespace Jobmanager\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SuperJobFrontType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Titre du poste :',
                'required' => true
            ))
            ->add('contract_type', 'text', array(
                'label' => 'Type de contrat :',
                'required' => true
            ))
            ->add('postingJob', 'textarea', array(
                'label' => 'Description du poste :',
                'required' => true
            ))
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
            'data_class' => 'Jobmanager\AdminBundle\Entity\Job'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jobmanager_frontbundle_jobfront';
    }
}
