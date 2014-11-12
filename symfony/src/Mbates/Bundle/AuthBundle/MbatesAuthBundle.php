<?php

namespace Mbates\Bundle\AuthBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Mbates\Bundle\AuthBundle\DependencyInjection\Compiler\OverrideServiceCompilerPass;

class MbatesAuthBundle extends Bundle
{
	public function build( ContainerBuilder $container )
	{
		parent::build( $container );
		$container->addCompilerPass( new OverrideServiceCompilerPass() );
	}
}
