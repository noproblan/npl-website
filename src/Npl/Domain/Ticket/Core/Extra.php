<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Core;

interface Extra
{
    public function getType(): ExtraType;

    public function getPrice(): int;
}
