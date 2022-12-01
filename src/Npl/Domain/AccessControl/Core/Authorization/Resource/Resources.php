<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core\Authorization\Resource;

use Npl\Domain\Shared\Core\Collection;

/**
 * @extends Collection<Resource>
 */
final class Resources extends Collection
{
    /**
     * @return Resource[]
     */
    public function getResources(): array
    {
        return $this->getItems();
    }

    protected function getCollectionType(): string
    {
        return Resource::class;
    }
}
