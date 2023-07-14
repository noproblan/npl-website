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

namespace Npl\IAM\Application\HasPermission;

class HasPermissionRequest
{
    public function __construct(
        private readonly string $userId,
        private readonly string $actionName,
        private readonly string $resourceName
    ) {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getActionName(): string
    {
        return $this->actionName;
    }

    public function getResourceName(): string
    {
        return $this->resourceName;
    }
}
