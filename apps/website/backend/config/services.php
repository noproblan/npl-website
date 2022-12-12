<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $configurator) {
    $services = $configurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('Npl\\', '../../../../src/Npl');
    $services
        ->load('Npl\\Apps\\Website\\Backend\\', '../src')
        ->exclude('../src/WebsiteBackendKernel.php');
};
