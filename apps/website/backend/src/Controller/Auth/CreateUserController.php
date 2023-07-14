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
use Npl\IAM\Application\CreateUser\CreateUserRequest;
use Npl\IAM\Application\CreateUser\CreateUserService;
use Npl\IAM\Application\CreateUser\UserAlreadyExistsException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CreateUserController extends AbstractController
{
    public function __construct(private readonly CreateUserService $service)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $createUserRequest = new CreateUserRequest(
                (string) $request->request->get('email'),
                (string) $request->request->get('password')
            );
            $createUserResponse = $this->service->execute($createUserRequest);

            return $this->json(
                [
                    'status' => 'success',
                    'data' => [
                        'userId' => $createUserResponse->getUserId()
                    ]
                ],
                201
            );
        } catch (UserAlreadyExistsException $exception) {
            return $this->json(
                [
                    'status' => 'error',
                    'message' => 'Email is already registered'
                ]
            );
        } catch (Exception) {
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
