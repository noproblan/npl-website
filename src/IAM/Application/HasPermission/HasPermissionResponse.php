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

class HasPermissionResponse
{
    public function __construct(private readonly bool $hasPermission)
    {
    }

    public function hasPermission(): bool
    {
        return $this->hasPermission;
    }
}
