<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\Bus\Query;

interface QueryBus
{
    public function ask(Query $query): ?Response;
}
