<?php

declare(strict_types=1);

use Npl\Apps\Website\Backend\Controller\HealthCheck\HealthCheckGetController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('health-check_get', '/health-check')
        ->controller(HealthCheckGetController::class)
        ->methods(['GET']);
};
