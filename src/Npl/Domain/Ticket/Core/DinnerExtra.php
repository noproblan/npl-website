<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Core;

final class DinnerExtra implements Extra
{
    public function getType(): ExtraType
    {
        return ExtraType::DINNER;
    }

    public function getPrice(): int
    {
        return 15;
    }
}
