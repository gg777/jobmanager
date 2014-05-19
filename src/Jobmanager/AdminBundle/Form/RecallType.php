<?php

namespace Jobmanager\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecallType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createdDate', 'datetime', array('required' => false))
            ->add('recallDate', 'datetime', array('required' => false))
            ->add('isFirstContact', 'checkbox', array('required' => false))
            ->add('isRecalled', 'checkbox', array('required' => false))
            ->add('recruiter', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Recruiter',
                'property' => 'lastname'
            ))
            ->add('jobSource', 'entity', array(
                'class' => 'JobmanagerAdminBundle:JobSource',
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
            'data_class' => 'Jobmanager\AdminBundle\Entity\Recall'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jobmanager_adminbundle_recall';
    }
}
