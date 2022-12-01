<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\Bus\Query;

/**
 * @template Q of Query
 * @template R of Response
 */
interface QueryHandler
{
    /**
     * @param Q $query
     * @return R
     */
    public function __invoke(mixed $query): mixed;
}
