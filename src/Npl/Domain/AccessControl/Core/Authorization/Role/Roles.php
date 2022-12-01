<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core\Authorization\Role;

use Npl\Domain\Shared\Core\Collection;

/**
 * @extends Collection<Role>
 */
final class Roles extends Collection
{
    /**
     * @return Role[]
     */
    public function getRoles(): array
    {
        return $this->getItems();
    }
    protected function getCollectionType(): string
    {
        return Role::class;
    }
}
