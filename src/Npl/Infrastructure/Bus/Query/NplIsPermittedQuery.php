<?php

declare(strict_types=1);

namespace Npl\Infrastructure\Bus\Query;

use Npl\Domain\Shared\Core\AccessControl\IsPermittedQuery;

final class NplIsPermittedQuery implements IsPermittedQuery
{
    public function __construct(private readonly string $resourceName)
    {
    }

    public function getResourceName(): string
    {
        return $this->resourceName;
    }
}
