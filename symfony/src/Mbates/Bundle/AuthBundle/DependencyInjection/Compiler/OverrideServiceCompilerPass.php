<?php
namespace Mbates\Bundle\AuthBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OverrideServiceCompilerPass implements CompilerPassInterface
{
	public function process( ContainerBuilder $container )
	{
		$definition = $container->getDefinition('fos_oauth_server.controller.token');
		$definition->setClass('Mbates\Bundle\AuthBundle\Controller\TokenController');
	}
}