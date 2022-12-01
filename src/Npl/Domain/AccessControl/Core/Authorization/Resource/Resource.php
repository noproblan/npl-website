<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core\Authorization\Resource;

use Npl\Domain\Shared\Core\Aggregate\AggregateRoot;

final class Resource extends AggregateRoot
{
    public function __construct(private readonly ResourceId $resourceId, private readonly ResourceName $resourceName)
    {
    }

    public function getResourceId(): ResourceId
    {
        return $this->resourceId;
    }

    public function getResourceName(): ResourceName
    {
        return $this->resourceName;
    }
}
