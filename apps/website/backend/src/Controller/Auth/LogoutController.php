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

namespace Npl\Apps\Website\Backend\Controller\Auth;

use Exception;
use InvalidArgumentException;
use Npl\IAM\Application\Login\BadCredentialsException;
use Npl\IAM\Application\Login\LoginRequest;
use Npl\IAM\Application\Login\LoginService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class LogoutController extends AbstractController
{
    public function __construct()
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $session = $request->getSession();
            $session->clear();
        } catch (Exception) {
            // no session set, we don't care then
        }

        return new JsonResponse([
            'status' => 'success',
            'data' => null
        ]);
    }
}
