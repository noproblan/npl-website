<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core\Authorization\Right;

use Npl\Domain\Shared\Core\Collection;

/**
 * @extends Collection<Right>
 */
final class Rights extends Collection
{
    /**
     * @return Right[]
     */
    public function getRights(): array
    {
        return $this->getItems();
    }
    protected function getCollectionType(): string
    {
        return Right::class;
    }
}
