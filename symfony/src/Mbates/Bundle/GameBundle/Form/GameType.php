<?php

namespace Mbates\Bundle\GameBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GameType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options )
	{
		$builder->add( 'id', 'hidden', array( 'mapped' => false ) ) 
				->add( 'title', 'text' )
				->add( 'notes', 'text', array( 'required' => false ) );
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions( OptionsResolverInterface $resolver )
	{
		$resolver->setDefaults(array(
			'data_class' => 'Mbates\Bundle\GameBundle\Entity\Game'
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
