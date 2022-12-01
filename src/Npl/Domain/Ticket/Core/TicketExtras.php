<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Core;

use Npl\Domain\Shared\Core\ValueObject\ValueObject;

final class TicketExtras implements ValueObject
{
    /**
     * @param Extra[] $extras
     */
    public function __construct(
        private readonly array $extras
    ) {
    }

    public function isEqual(ValueObject $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    public function getValue(): string
    {
        $extraTypes = array_map(
            static fn(Extra $extra) => $extra->getType()->getValue(),
            $this->extras
        );

        return implode(
            ',',
            $extraTypes
        );
    }

    public function getPrice(): int
    {
        return array_reduce(
            $this->extras,
            static function (int $sum, Extra $extra) {
                $sum += $extra->getPrice();
                return $sum;
            },
            0
        );
    }
}
