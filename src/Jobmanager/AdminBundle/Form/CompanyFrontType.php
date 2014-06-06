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
            ->add('name', 'text', array(
                'label' => '* Entreprise :'
            ))
            ->add('address', 'textarea', array(
                'label' => 'Adresse :',
                'required' => false
            ))
            ->add('zip', 'text', array(
                'label' => 'Code postale :',
                'required' => false
            ))
            ->add('city', 'text', array(
                'label' => 'Ville :',
                'required' => false
            ))
            ->add('urlCompany', 'text', array(
                'label' => 'Site web :',
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
