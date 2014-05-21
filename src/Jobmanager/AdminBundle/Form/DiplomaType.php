<?php

namespace Jobmanager\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DiplomaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('required' => false))
            ->add('date', 'date', array('required' => false))
            ->add('formation', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Formation',
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
            'data_class' => 'Jobmanager\AdminBundle\Entity\Diploma'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jobmanager_adminbundle_diploma';
    }
}
