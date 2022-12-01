<?php

declare(strict_types=1);

namespace Npl\Domain\Lan\Core;

use Npl\Domain\Shared\Core\Criteria\Criteria;

interface LanRepository
{
    public function loadAll(): array;

    public function loadByCriteria(Criteria $criteria): Lans;

    public function save(Lan $lan): void;
}
