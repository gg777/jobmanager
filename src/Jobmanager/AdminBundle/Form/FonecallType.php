<?php

namespace Jobmanager\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FonecallType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateBegin', 'datetime', array('required' => false))
            ->add('dateEnd', 'datetime', array('required' => false))
            ->add('type', 'text', array('required' => false))
            ->add('description', 'textarea', array('required' => false))
            ->add('isInbound', 'checkbox', array('required' => false))
            ->add('source', 'text', array('required' => false))
            ->add('candidate_job', 'entity', array(
                'class' => 'JobmanagerAdminBundle:CandidateJob',
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
            'data_class' => 'Jobmanager\AdminBundle\Entity\Fonecall'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jobmanager_adminbundle_fonecall';
    }
}
