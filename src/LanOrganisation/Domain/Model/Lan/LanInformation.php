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

namespace Npl\LanOrganisation\Domain\Model\Lan;

use InvalidArgumentException;

class LanInformation
{
    private string $title;
    private string $info;

    public function __construct(
        string $title,
        string $information
    ) {
        $this->setTitle($title);
        $this->setInfo($information);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getInfo(): string
    {
        return $this->info;
    }

    public function isEqualTo(LanInformation $other): bool
    {
        return $this->getTitle() === $other->getTitle()
            && $this->getInfo() === $other->getInfo();
    }

    private function setTitle(string $title): void
    {
        $this->assertNotEmpty('title', $title);
        $this->title = $title;
    }

    private function setInfo(string $info): void
    {
        $this->assertNotEmpty('info', $info);
        $this->info = $info;
    }

    private function assertNotEmpty(string $field, string $value): void
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Empty ' . $field);
        }
    }
}
