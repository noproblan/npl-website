<?php

declare(strict_types=1);

use Npl\Apps\Website\Backend\Controller\Auth\CreateUserController;
use Npl\Apps\Website\Backend\Controller\Auth\LoginController;
use Npl\Apps\Website\Backend\Controller\Auth\LogoutController;
use Npl\Apps\Website\Backend\Controller\HealthCheck\HealthCheckGetController;
use Npl\Apps\Website\Backend\Controller\Test\TestGetController;
use Npl\Apps\Website\Backend\Controller\Ticket\ReserveTicketController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\Requirement\Requirement;

return function (RoutingConfigurator $routes) {
    $routes->add('health-check_get', '/health-check')
        ->controller(HealthCheckGetController::class)
        ->methods(['GET']);

    $routes
        ->import('./routes/auth.php')
        ->prefix('/auth');

    $routes
        ->import('./routes/lan.php')
        ->prefix('/lan');

    $routes
        ->import('./routes/ticket.php')
        ->prefix('/ticket');
};
