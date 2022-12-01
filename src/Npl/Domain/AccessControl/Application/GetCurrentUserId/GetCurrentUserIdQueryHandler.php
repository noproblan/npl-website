<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Application\GetCurrentUserId;

use Npl\Domain\Shared\Core\Bus\Query\QueryHandler;

/**
 * @implements QueryHandler<GetCurrentUserIdQuery, CurrentUserIdResponse>
 */
final class GetCurrentUserIdQueryHandler implements QueryHandler
{
    public function __construct(private readonly CurrentUserIdLoader $loader)
    {
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __invoke(mixed $query): CurrentUserIdResponse
    {
        $currentUserId = $this->loader->getCurrentUserId();

        return new CurrentUserIdResponse($currentUserId->getValue());
    }
}
