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

namespace Npl\LanOrganisation\Application\Shared;

class LanInfoRequest
{
    public function __construct(
        private readonly string $lanId,
        private readonly string $title,
        private readonly string $info
    ) {
    }

    public function getLanId(): string
    {
        return $this->lanId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getInfo(): string
    {
        return $this->info;
    }
}
