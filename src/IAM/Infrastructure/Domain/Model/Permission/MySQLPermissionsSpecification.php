<?php

/*
 * This file is part of the noprobLAN Website.
 *
 * Copyright (c) 2023 Fabian Schweizer <fa.schweizer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Npl\IAM\Infrastructure\Domain\Model\Permission;

use Npl\IAM\Domain\Model\Permission\Action;
use Npl\IAM\Domain\Model\Permission\Permission;
use Npl\IAM\Domain\Model\Permission\PermissionSpecification;
use Npl\IAM\Domain\Model\Permission\Resource;
use Npl\IAM\Infrastructure\Persistence\MySQL\MySQLSpecification;

class MySQLPermissionsSpecification implements PermissionSpecification, MySQLSpecification
{
    public function __construct(private readonly Action $action, private readonly Resource $resource)
    {
    }

    public function isSatisfiedBy(Permission $permission): bool
    {
        return $this->action->isEqualTo($permission->getAction())
            && $this->resource->isEqualTo($permission->getResource());
    }

    public function toSqlClauses(): string
    {
        return 'where `action` = ' . $this->action->getValue() . ' AND `resource` = ' . $this->resource->getValue();
    }
}
