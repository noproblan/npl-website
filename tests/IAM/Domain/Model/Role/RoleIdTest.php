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

namespace Tests\IAM\Domain\Model\Role;

use InvalidArgumentException;
use Npl\IAM\Domain\Model\Role\RoleId;
use PHPUnit\Framework\TestCase;

class RoleIdTest extends TestCase
{
    private string $validRoleId = 'aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa';

    /**
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::fromString
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::__construct
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::setValue
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::assertValidUuid
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::getValue
     */
    public function testGetValue(): void
    {
        $roleId = RoleId::fromString($this->validRoleId);
        self::assertEquals($this->validRoleId, $roleId->getValue());
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::fromString
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::__construct
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::setValue
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::assertValidUuid
     */
    public function testFromString(): void
    {
        self::expectNotToPerformAssertions();
        RoleId::fromString($this->validRoleId);
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::fromString
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::__construct
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::setValue
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::assertValidUuid
     */
    public function testFromStringThrowsOnInvalidRoleId(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage(
            '"banana" is not a valid Npl\IAM\Domain\Model\Role\RoleId'
        );
        RoleId::fromString('banana');
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::fromString
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::__construct
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::setValue
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::assertValidUuid
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::isEqualTo
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::getValue
     */
    public function testIsEqualTo(): void
    {
        $roleIdOne = RoleId::fromString($this->validRoleId);
        $roleIdTwo = RoleId::fromString($this->validRoleId);
        $otherId = str_replace('a', 'b', $this->validRoleId);
        $roleIdThree = RoleId::fromString($otherId);
        self::assertTrue($roleIdOne->isEqualTo($roleIdTwo));
        self::assertFalse($roleIdOne->isEqualTo($roleIdThree));
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::create
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::__construct
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::assertValidUuid
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::setValue
     */
    public function testCreate(): void
    {
        self::expectNotToPerformAssertions();
        RoleId::create();
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::fromString
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::__construct
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::setValue
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::assertValidUuid
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::getValue
     * @covers \Npl\IAM\Domain\Model\Role\RoleId::__toString
     */
    public function testToString(): void
    {
        $uuid = RoleId::fromString($this->validRoleId);
        self::assertNotEmpty((string)$uuid);
        self::assertEquals($this->validRoleId, (string)$uuid);
    }
}

