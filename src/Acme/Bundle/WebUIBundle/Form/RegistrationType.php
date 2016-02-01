<?php

namespace Acme\Bundle\WebUIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $builder->add('mobile');
        $builder
            ->add('email', 'email', array('label' => '邮箱：'))
            ->add('username', null, array('label' => '用户名：'))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                // 'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => false),
                'second_options' => array('label' => false),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            // ->add('plainPassword', 'repeated')
            ->add('mobile', null, array('label' => '手机：'));
        ;
    }

    public function getParent()
    {
        // return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}