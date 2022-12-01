<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Application\Ports;

use Npl\Domain\AccessControl\Core\Authorization\Resource\Resources;
use Npl\Domain\Shared\Core\Criteria\Criteria;

interface ResourceRepository
{
    public function loadByCriteria(Criteria $criteria): Resources;
}
