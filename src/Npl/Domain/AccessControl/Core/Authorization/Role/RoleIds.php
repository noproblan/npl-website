<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core\Authorization\Role;

use Npl\Domain\Shared\Core\Collection;

/**
 * @extends Collection<RoleId>
 */
final class RoleIds extends Collection
{
    /**
     * @return RoleId[]
     */
    public function getRoleIds(): array
    {
        return $this->getItems();
    }

    protected function getCollectionType(): string
    {
        return Role::class;
    }
}
