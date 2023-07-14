<?php

/*
 * This file is part of the noprobLAN Website.
 *
 * Copyright (c) 2023 Fabian Schweizer <fa.schweizer@gmail.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests\Common\Domain\Model;

use InvalidArgumentException;
use Npl\Common\Domain\Model\Uuid;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    private string $validUuid = 'aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa';

    /**
     * @covers \Npl\Common\Domain\Model\Uuid::create
     * @covers \Npl\Common\Domain\Model\Uuid::__construct
     * @covers \Npl\Common\Domain\Model\Uuid::assertValidUuid
     * @covers \Npl\Common\Domain\Model\Uuid::setValue
     */
    public function testCreate(): void
    {
        self::expectNotToPerformAssertions();
        Uuid::create();
    }

    /**
     * @covers \Npl\Common\Domain\Model\Uuid::fromString
     * @covers \Npl\Common\Domain\Model\Uuid::__construct
     * @covers \Npl\Common\Domain\Model\Uuid::assertValidUuid
     * @covers \Npl\Common\Domain\Model\Uuid::setValue
     * @covers \Npl\Common\Domain\Model\Uuid::__toString
     * @covers \Npl\Common\Domain\Model\Uuid::getValue
     */
    public function testToString(): void
    {
        $uuid = Uuid::fromString($this->validUuid);
        self::assertNotEmpty((string)$uuid);
        self::assertEquals($this->validUuid, (string)$uuid);
    }

    /**
     * @covers \Npl\Common\Domain\Model\Uuid::fromString
     * @covers \Npl\Common\Domain\Model\Uuid::__construct
     * @covers \Npl\Common\Domain\Model\Uuid::setValue
     * @covers \Npl\Common\Domain\Model\Uuid::assertValidUuid
     */
    public function testFromStringThrowsOnInvalidUuid(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage(
            '"banana" is not a valid UUID'
        );
        Uuid::fromString('banana');
    }

    /**
     * @covers \Npl\Common\Domain\Model\Uuid::fromString
     * @covers \Npl\Common\Domain\Model\Uuid::__construct
     * @covers \Npl\Common\Domain\Model\Uuid::setValue
     * @covers \Npl\Common\Domain\Model\Uuid::assertValidUuid
     */
    public function testFromString(): void
    {
        self::expectNotToPerformAssertions();
        Uuid::fromString($this->validUuid);
    }

    /**
     * @covers \Npl\Common\Domain\Model\Uuid::fromString
     * @covers \Npl\Common\Domain\Model\Uuid::__construct
     * @covers \Npl\Common\Domain\Model\Uuid::setValue
     * @covers \Npl\Common\Domain\Model\Uuid::assertValidUuid
     * @covers \Npl\Common\Domain\Model\Uuid::getValue
     */
    public function testGetValue(): void
    {
        $uuid = Uuid::fromString($this->validUuid);
        self::assertNotEmpty($uuid->getValue());
        self::assertEquals($this->validUuid, $uuid->getValue());
    }

    /**
     * @covers \Npl\Common\Domain\Model\Uuid::fromString
     * @covers \Npl\Common\Domain\Model\Uuid::__construct
     * @covers \Npl\Common\Domain\Model\Uuid::setValue
     * @covers \Npl\Common\Domain\Model\Uuid::assertValidUuid
     * @covers \Npl\Common\Domain\Model\Uuid::isEqualTo
     * @covers \Npl\Common\Domain\Model\Uuid::getValue
     */
    public function testIsEqualTo(): void
    {
        $firstUuid = Uuid::fromString($this->validUuid);
        $secondUuid = Uuid::fromString($this->validUuid);
        $thirdUuid = Uuid::fromString('baaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa');

        self::assertTrue($firstUuid->isEqualTo($secondUuid));
        self::assertFalse($firstUuid->isEqualTo($thirdUuid));
    }
}
