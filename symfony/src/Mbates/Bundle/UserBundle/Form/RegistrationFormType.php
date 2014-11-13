<?php
namespace Mbates\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // add your custom field
        $builder->add('given_name', 'text', array(
                    'label' => false,
                    'attr' => array('placeholder' => 'Given Name:')
                ))
                ->add('family_name', 'text', array(
                    'label' => false,
                    'attr' => array('placeholder' => 'Family Name:')
                ))
                ->add('email', 'email', array(
                    'label' => false,
                    'attr' => array('placeholder' => 'form.email', 'autocomplete' => 'off'),
                    'translation_domain' => 'FOSUserBundle'
                ))
                ->add('username', null, array(
                    'label' => false,
                    'attr' => array('placeholder' => 'form.username', 'autocomplete' => 'off'),
                    'translation_domain' => 'FOSUserBundle'
                ))
                ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => false, 'attr' => array('placeholder' => 'form.password', 'autocomplete' => 'off')),
                    'second_options' => array('label' => false, 'attr' => array('placeholder' => 'form.password_confirmation', 'autocomplete' => 'off')),
                    'invalid_message' => 'fos_user.password.mismatch',
                ));
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'mbates_user_registration';
    }
}