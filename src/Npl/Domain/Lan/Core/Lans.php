<?php

declare(strict_types=1);

namespace Npl\Domain\Lan\Core;

use Npl\Domain\Shared\Core\Collection;

/**
 * @extends Collection<Lan>
 */
final class Lans extends Collection
{
    /**
     * @return Lan[]
     */
    public function getLans(): array
    {
        return $this->getItems();
    }

    protected function getCollectionType(): string
    {
        return Lan::class;
    }
}
