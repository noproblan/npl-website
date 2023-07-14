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

namespace Tests\Shared\Domain\Model;

use InvalidArgumentException;
use Npl\Shared\Domain\Model\UserId;
use PHPUnit\Framework\TestCase;

class UserIdTest extends TestCase
{
    private string $validUserId = 'aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa';

    /**
     * @covers \Npl\Shared\Domain\Model\UserId::create
     * @covers \Npl\Shared\Domain\Model\UserId::__construct
     * @covers \Npl\Shared\Domain\Model\UserId::setValue
     * @covers \Npl\Shared\Domain\Model\UserId::assertValidUuid
     */
    public function testCreate(): void
    {
        self::expectNotToPerformAssertions();
        UserId::create();
    }

    /**
     * @covers \Npl\Shared\Domain\Model\UserId::fromString
     * @covers \Npl\Shared\Domain\Model\UserId::__construct
     * @covers \Npl\Shared\Domain\Model\UserId::__toString
     * @covers \Npl\Shared\Domain\Model\UserId::assertValidUuid
     * @covers \Npl\Shared\Domain\Model\UserId::getValue
     * @covers \Npl\Shared\Domain\Model\UserId::setValue
     */
    public function testToString(): void
    {
        $uuid = UserId::fromString($this->validUserId);
        self::assertNotEmpty((string)$uuid);
        self::assertEquals($this->validUserId, (string)$uuid);
    }

    /**
     * @covers \Npl\Shared\Domain\Model\UserId::fromString
     * @covers \Npl\Shared\Domain\Model\UserId::__construct
     * @covers \Npl\Shared\Domain\Model\UserId::__toString
     * @covers \Npl\Shared\Domain\Model\UserId::assertValidUuid
     * @covers \Npl\Shared\Domain\Model\UserId::getValue
     * @covers \Npl\Shared\Domain\Model\UserId::setValue
     */
    public function testFromStringThrowsOnInvalidUserId(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage(
            '"banana" is not a valid Npl\Shared\Domain\Model\UserId'
        );
        UserId::fromString('banana');
    }

    /**
     * @covers \Npl\Shared\Domain\Model\UserId::fromString
     * @covers \Npl\Shared\Domain\Model\UserId::__construct
     * @covers \Npl\Shared\Domain\Model\UserId::__toString
     * @covers \Npl\Shared\Domain\Model\UserId::assertValidUuid
     * @covers \Npl\Shared\Domain\Model\UserId::getValue
     * @covers \Npl\Shared\Domain\Model\UserId::setValue
     */
    public function testFromString(): void
    {
        self::expectNotToPerformAssertions();
        UserId::fromString($this->validUserId);
    }

    /**
     * @covers \Npl\Shared\Domain\Model\UserId::fromString
     * @covers \Npl\Shared\Domain\Model\UserId::__construct
     * @covers \Npl\Shared\Domain\Model\UserId::__toString
     * @covers \Npl\Shared\Domain\Model\UserId::assertValidUuid
     * @covers \Npl\Shared\Domain\Model\UserId::getValue
     * @covers \Npl\Shared\Domain\Model\UserId::setValue
     */
    public function testGetValue(): void
    {
        $uuid = UserId::fromString($this->validUserId);
        self::assertNotEmpty($uuid->getValue());
        self::assertEquals($this->validUserId, $uuid->getValue());
    }

    /**
     * @covers \Npl\Shared\Domain\Model\UserId::fromString
     * @covers \Npl\Shared\Domain\Model\UserId::__construct
     * @covers \Npl\Shared\Domain\Model\UserId::__toString
     * @covers \Npl\Shared\Domain\Model\UserId::assertValidUuid
     * @covers \Npl\Shared\Domain\Model\UserId::getValue
     * @covers \Npl\Shared\Domain\Model\UserId::setValue
     * @covers \Npl\Shared\Domain\Model\UserId::isEqualTo
     */
    public function testIsEqualTo(): void
    {
        $firstUserId = UserId::fromString($this->validUserId);
        $secondUserId = UserId::fromString($this->validUserId);
        $thirdUserId = UserId::fromString('baaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa');

        self::assertTrue($firstUserId->isEqualTo($secondUserId));
        self::assertFalse($firstUserId->isEqualTo($thirdUserId));
    }
}
