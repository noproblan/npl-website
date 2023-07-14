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

namespace Npl\Shared\Domain\Model;

class TicketId
{
    private int $value;

    final public function __construct(int $value)
    {
        $this->setValue($value);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function isEqualTo(TicketId $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    private function setValue(int $value): void
    {
        $this->value = $value;
    }
}
