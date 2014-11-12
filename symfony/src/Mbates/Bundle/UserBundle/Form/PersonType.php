<?php
namespace Mbates\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder->add('username', 'text')
                ->add('given_name', 'text')
                ->add('family_name', 'text')
                ->add('phone', 'text')
                ->add('email', 'text')
                ->add('password', 'text', array('required' => false));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions( OptionsResolverInterface $resolver )
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mbates\Bundle\UserBundle\Entity\Person'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}
