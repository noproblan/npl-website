<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Application\IsPermitted;

use Npl\Domain\Shared\Core\Bus\Query\QueryHandler;
use Npl\Infrastructure\Bus\Query\NplIsPermittedQuery;

/**
 * @implements QueryHandler<NplIsPermittedQuery, IsPermittedResponse>
 */
final class IsPermittedQueryHandler implements QueryHandler
{
    public function __construct(private readonly PermissionChecker $checker)
    {
    }

    public function __invoke(mixed $query): IsPermittedResponse
    {
        $resourceName = $query->getResourceName();
        $isPermitted = $this->checker->check($resourceName);

        return new IsPermittedResponse($isPermitted);
    }
}
