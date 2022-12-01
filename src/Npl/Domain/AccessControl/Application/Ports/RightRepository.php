<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Application\Ports;

use Npl\Domain\AccessControl\Core\Authorization\Right\Rights;
use Npl\Domain\Shared\Core\Criteria\Criteria;

interface RightRepository
{
    public function loadByCriteria(Criteria $criteria): Rights;
}
