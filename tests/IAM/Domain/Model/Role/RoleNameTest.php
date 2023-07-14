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
use Npl\IAM\Domain\Model\Role\RoleName;
use PHPUnit\Framework\TestCase;

class RoleNameTest extends TestCase
{
    /**
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::fromString
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::__construct
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::setValue
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::assertNotEmpty
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::assertValidFormat
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::isEqualTo
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::getValue
     */
    public function testIsEqualTo(): void
    {
        $roleNameOne = RoleName::fromString('RoleNameOne');
        $roleNameTwo = RoleName::fromString('RoleNameOne');
        $roleNameThree = RoleName::fromString('RoleNameThree');
        self::assertTrue($roleNameOne->isEqualTo($roleNameTwo));
        self::assertFalse($roleNameOne->isEqualTo($roleNameThree));
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::fromString
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::__construct
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::setValue
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::assertNotEmpty
     */
    public function testFromStringThrowsErrorWhenRoleNameIsEmpty(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Empty role name');
        RoleName::fromString('');
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::fromString
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::__construct
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::setValue
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::assertNotEmpty
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::assertValidFormat
     */
    public function testFromStringThrowsErrorWhenRoleNameHasInvalidFormat(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Invalid role name format');
        RoleName::fromString('Invalid Format');
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::fromString
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::__construct
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::setValue
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::assertNotEmpty
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::assertValidFormat
     */
    public function testFromString(): void
    {
        self::expectNotToPerformAssertions();
        RoleName::fromString('CamelCase');
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::fromString
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::__construct
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::setValue
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::assertNotEmpty
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::assertValidFormat
     * @covers \Npl\IAM\Domain\Model\Role\RoleName::getValue
     */
    public function testGetValue(): void
    {
        $roleName = RoleName::fromString('GetValue');
        self::assertEquals('GetValue', $roleName->getValue());
    }
}

