<?php

declare(strict_types=1);

namespace Tests\Domain\Ticket\Core;

use Npl\Domain\Ticket\Core\BreakfastExtra;
use Npl\Domain\Ticket\Core\ExtraType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Npl\Domain\Ticket\Core\BreakfastExtra
 */
class BreakfastExtraTest extends TestCase
{
    public function testGetPrice(): void
    {
        $breakfastExtra = new BreakfastExtra();
        static::assertEquals(15, $breakfastExtra->getPrice());
    }

    public function testGetType(): void
    {
        $breakfastExtra = new BreakfastExtra();
        static::assertEquals(ExtraType::BREAKFAST, $breakfastExtra->getType());
    }
}
