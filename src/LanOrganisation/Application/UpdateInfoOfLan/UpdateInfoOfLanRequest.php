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

namespace Npl\LanOrganisation\Application\UpdateInfoOfLan;

class UpdateInfoOfLanRequest
{
    public function __construct(
        private readonly string $lanId,
        private readonly string $previousTitle,
        private readonly string $previousInfo,
        private readonly string $newTitle,
        private readonly string $newInfo,
    ) {
    }
    public function getLanId(): string
    {
        return $this->lanId;
    }

    public function getPreviousTitle(): string
    {
        return $this->previousTitle;
    }

    public function getPreviousInfo(): string
    {
        return $this->previousInfo;
    }

    public function getNewTitle(): string
    {
        return $this->newTitle;
    }

    public function getNewInfo(): string
    {
        return $this->newInfo;
    }
}
