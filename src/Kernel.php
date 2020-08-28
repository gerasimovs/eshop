<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * {@inheritDoc}
     * @throws \Exception
     */
    protected function configureContainer(ContainerConfigurator $c, LoaderInterface $loader): void
    {
        $configDir = $this->getProjectDir() . '/config';
        $loader->load($configDir . '/framework.yaml', 'glob');
        $loader->load($configDir . '/packages/*.yaml', 'glob');

        $c->services()
            ->load('App\\', __DIR__ . '/*')
            ->autowire()
            ->autoconfigure();
    }

    /**
     * {@inheritDoc}
     */
    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import(__DIR__ . '/Controller/', 'annotation');
    }
}
