<?php

namespace Jobmanager\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LanguageType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('level', 'text')
            ->add('candidates', 'entity', array(
                'class' => 'JobmanagerAdminBundle:Candidate',
                'property' => 'lastname',
                'multiple' => true
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jobmanager\AdminBundle\Entity\Language'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jobmanager_adminbundle_language';
    }
}
