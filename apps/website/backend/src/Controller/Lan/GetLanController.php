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

namespace Npl\Apps\Website\Backend\Controller\Lan;

use Exception;
use InvalidArgumentException;
use Npl\LanOrganisation\Application\GetLanById\GetLanByIdRequest;
use Npl\LanOrganisation\Application\GetLanById\GetLanByIdService;
use Npl\LanOrganisation\Application\LanDoesNotExistException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetLanController extends AbstractController
{
    public function __construct(private readonly GetLanByIdService $service)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $routeParams = $request->attributes->get('_route_params');
            $lanRequest = new GetLanByIdRequest($routeParams['lanId']);
            $lanResponse = $this->service->execute($lanRequest);

            return new JsonResponse([
                'status' => 'success',
                'data' => [
                    'lan' => $lanResponse
                ]
            ]);
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(
                [
                    'status' => 'error',
                    'message' => $exception->getMessage()
                ]
            );
        } catch (LanDoesNotExistException) {
            return new JsonResponse(
                [
                    'status' => 'error',
                    'message' => 'Invalid lan id provided'
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
