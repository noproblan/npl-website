<?php

declare(strict_types=1);

namespace Npl\Apps\Website\Backend\Controller\HealthCheck;

use Npl\Domain\Shared\Core\RandomNumberGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class HealthCheckGetController extends AbstractController
{
    public function __construct(private readonly RandomNumberGenerator $generator)
    {
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(
            [
                'npl-website' => 'ok',
                'rand' => $this->generator->generate()
            ]
        );
    }
}
