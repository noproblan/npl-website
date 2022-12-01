<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Core;

final class BreakfastExtra implements Extra
{
    public function getType(): ExtraType
    {
        return ExtraType::BREAKFAST;
    }

    public function getPrice(): int
    {
        return 15;
    }
}
