<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\OAuthServerBundle\FOSOAuthServerBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
            new Nelmio\CorsBundle\NelmioCorsBundle(),
            new Liip\CacheControlBundle\LiipCacheControlBundle(),
            new Bazinga\Bundle\HateoasBundle\BazingaHateoasBundle(),
            new Hautelook\TemplatedUriBundle\HautelookTemplatedUriBundle(),
            new Bazinga\Bundle\RestExtraBundle\BazingaRestExtraBundle(),
            new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Cocur\Slugify\Bridge\Symfony\CocurSlugifyBundle(),
            new Mbates\Bundle\AdminBundle\MbatesAdminBundle(),
            new Mbates\Bundle\ApiBundle\MbatesApiBundle(),
            new Mbates\Bundle\AssetsBundle\MbatesAssetsBundle(),
            new Mbates\Bundle\AuthBundle\MbatesAuthBundle(),
            new Mbates\Bundle\FixtureBundle\MbatesFixtureBundle(),
            new Mbates\Bundle\GameBundle\MbatesGameBundle(),
            new Mbates\Bundle\UserBundle\MbatesUserBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
