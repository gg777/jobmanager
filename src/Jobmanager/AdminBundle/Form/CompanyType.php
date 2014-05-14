<?php

namespace Jobmanager\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompanyType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('address', 'textarea')
            ->add('zip', 'text')
            ->add('city', 'text')
            ->add('country', 'text')
            ->add('lat', 'text')
            ->add('lng', 'text')
            ->add('is_head_hunter', 'checkbox', array('required' => false))
            ->add('urlCompany', 'text')
            ->add('recruiter', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Recruiter',
                'property' => 'lastname'
            ))
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
