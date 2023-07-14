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
use Symfony\Component\HttpFoundation\Session\Session;

class LoginController extends AbstractController
{
    public function __construct(private readonly LoginService $service)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $loginRequest = new LoginRequest(
                (string) $request->request->get('email'),
                (string) $request->request->get('password')
            );
            $loginResponse = $this->service->execute($loginRequest);
            $userId = $loginResponse->getUserId();

            $session = $request->getSession();
            $session->set('userId', $userId);

            return new JsonResponse([
                'status' => 'success',
                'data' => null
            ]);
        } catch (BadCredentialsException | InvalidArgumentException) {
            return new JsonResponse(
                [
                    'status' => 'error',
                    'message' => 'Invalid credentials provided'
                ],
                400
            );
        } catch (Exception $exception) {
            echo "<pre>"; var_dump($exception);die(); // TODO: Remove this
            return $this->json(
                [
                    'status' => 'error',
                    'message' => 'Something went wrong'
                ],
                500
            );
        }
    }
}
