<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core\Authorization\UserRole;

use Npl\Domain\Shared\Core\Collection;

/**
 * @extends Collection<UserRole>
 */
final class UserRoles extends Collection
{
    /**
     * @return UserRole[]
     */
    public function getUserRoles(): array
    {
        return $this->getItems();
    }
    protected function getCollectionType(): string
    {
        return UserRole::class;
    }
}
