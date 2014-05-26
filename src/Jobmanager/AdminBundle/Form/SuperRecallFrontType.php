<?php

namespace Jobmanager\AdminBundle\Form;

use Jobmanager\AdminBundle\Entity\Recruiter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SuperRecallFrontType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recruiter', new RecruiterFrontType(), array(
                'label' => false
            ))

            ->add('description', 'textarea', array(
                'label' => 'Description du poste :',
                'required' => false))
            ->add('captcha', 'captcha', array(
                'width' => '100',
                'height' => '35',
                'background_color' => array(255, 255, 255),
                'label' => '* Antispam :'
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
        return 'jobmanager_adminbundle_superrecallfront';
    }
}
