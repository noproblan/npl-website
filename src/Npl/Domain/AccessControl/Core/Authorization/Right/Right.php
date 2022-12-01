<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core\Authorization\Right;

use Npl\Domain\AccessControl\Core\Authorization\Resource\ResourceId;
use Npl\Domain\AccessControl\Core\Authorization\Role\RoleId;
use Npl\Domain\Shared\Core\Aggregate\AggregateRoot;

final class Right extends AggregateRoot
{
    public function __construct(private readonly RoleId $roleId, private readonly ResourceId $resourceId)
    {
    }

    public function getRoleId(): RoleId
    {
        return $this->roleId;
    }

    public function getResourceId(): ResourceId
    {
        return $this->resourceId;
    }
}
