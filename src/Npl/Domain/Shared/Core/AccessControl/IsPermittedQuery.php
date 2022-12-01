<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\AccessControl;

use Npl\Domain\Shared\Core\Bus\Query\Query;

interface IsPermittedQuery extends Query
{
    public function getResourceName(): string;
}
