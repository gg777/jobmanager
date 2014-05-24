<?php

namespace Jobmanager\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompanyFrontType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('required' => false))
            ->add('type', 'text', array('required' => false))
            ->add('sector', 'text', array('required' => false))
            ->add('address', 'textarea', array('required' => false))
            ->add('zip', 'text', array('required' => false))
            ->add('city', 'text', array('required' => false))
            ->add('country', 'text', array('required' => false))
            ->add('is_head_hunter', 'checkbox', array('required' => false))
            ->add('urlCompany', 'text', array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jobmanager\AdminBundle\Entity\Company'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jobmanager_adminbundle_company';
    }
}
