<?php

/*
 * This file is part of the noprobLAN Website.
 *
 * Copyright (c) 2023 Fabian Schweizer <fa.schweizer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Npl\Apps\Website\Backend\Controller\Auth\CreateUserController;
use Npl\Apps\Website\Backend\Controller\Auth\LoginController;
use Npl\Apps\Website\Backend\Controller\Auth\LogoutController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('login', '/login')
        ->controller(LoginController::class)
        ->methods(['POST']);

    $routes->add('logout', '/logout')
        ->controller(LogoutController::class)
        ->methods(['GET', 'POST']);

    $routes->add('create-user', '/register')
        ->controller(CreateUserController::class)
        ->methods(['POST']);
};
