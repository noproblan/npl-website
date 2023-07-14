<?php

declare(strict_types=1);

namespace Npl\Apps\Website\Backend\Controller\HealthCheck;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class HealthCheckGetController extends AbstractController
{
    public function __construct()
    {
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => 'success',
                'data' => [
                    'rand' => 3
                ]
            ]
        );
    }
}
