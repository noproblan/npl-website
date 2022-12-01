<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Core;

final class ExtraFactory
{
    public static function from(string $extra): Extra
    {
        $extraType = ExtraType::from($extra);

        return match ($extraType) {
            ExtraType::BREAKFAST => new BreakfastExtra(),
            ExtraType::DINNER => new DinnerExtra()
        };
    }
}
