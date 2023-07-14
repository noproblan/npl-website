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

use Npl\Apps\Website\Backend\Controller\Lan\GetLanController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\Requirement\Requirement;

return function (RoutingConfigurator $routes) {
//    $routes->add('get-lans', '/')
//        ->controller(GetLanController::class)
//        ->methods(['GET']);

    $routes->add('get-lan-by-id', '/{lanId}')
        ->controller(GetLanController::class)
        ->methods(['GET'])
        ->requirements(['lanId' => Requirement::UUID_V4]);
};
