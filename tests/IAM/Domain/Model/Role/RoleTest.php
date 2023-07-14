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

use Npl\IAM\Domain\Model\Permission\PermissionId;
use Npl\IAM\Domain\Model\Role\Role;
use Npl\IAM\Domain\Model\Role\RoleId;
use Npl\IAM\Domain\Model\Role\RoleName;
use Npl\IAM\Domain\Model\User\User;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase
{
    /**
     * @covers \Npl\IAM\Domain\Model\Role\Role::__construct
     */
    public function testConstruct(): void
    {
        self::expectNotToPerformAssertions();
        $roleId = self::createMock(RoleId::class);
        $roleName = self::createMock(RoleName::class);
        new Role($roleId, $roleName);
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Role\Role::__construct
     * @covers \Npl\IAM\Domain\Model\Role\Role::getRoleId
     */
    public function testGetRoleId(): void
    {
        $roleId = self::createMock(RoleId::class);
        $roleName = self::createMock(RoleName::class);
        $role = new Role($roleId, $roleName);
        self::assertEquals($roleId, $role->getRoleId());
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Role\Role::__construct
     * @covers \Npl\IAM\Domain\Model\Role\Role::getRoleName
     */
    public function testGetRoleName(): void
    {
        $roleId = self::createMock(RoleId::class);
        $roleName = self::createMock(RoleName::class);
        $role = new Role($roleId, $roleName);
        self::assertEquals($roleName, $role->getRoleName());
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Role\Role::__construct
     * @covers \Npl\IAM\Domain\Model\Role\Role::changeName
     * @covers \Npl\IAM\Domain\Model\Role\Role::getRoleName
     * @covers \Npl\IAM\Domain\Model\Role\RoleName
     */
    public function testChangeName(): void
    {
        $roleId = self::createMock(RoleId::class);
        $roleName = self::createMock(RoleName::class);
        $role = new Role($roleId, $roleName, []);

        $roleName->expects(self::once())->method('isEqualTo')->willReturn(false);
        $role->changeName('New');
        self::assertEquals('New', $role->getRoleName()->getValue());
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Role\Role::__construct
     * @covers \Npl\IAM\Domain\Model\Role\Role::receivePermission
     * @covers \Npl\IAM\Domain\Model\Role\Role::hasPermission
     */
    public function testReceivePermission(): void
    {
        $roleId = self::createMock(RoleId::class);
        $roleName = self::createMock(RoleName::class);
        $permissionId = self::createMock(PermissionId::class);
        $role = new Role($roleId, $roleName, []);

        self::assertFalse($role->hasPermission($permissionId));
        $permissionId->expects(self::once())->method('isEqualTo')->with($permissionId)->willReturn(true);
        $role->receivePermission($permissionId);
        self::assertTrue($role->hasPermission($permissionId));
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Role\Role::__construct
     * @covers \Npl\IAM\Domain\Model\Role\Role::losePermission
     * @covers \Npl\IAM\Domain\Model\Role\Role::hasPermission
     */
    public function testLosePermission(): void
    {
        $roleId = self::createMock(RoleId::class);
        $roleName = self::createMock(RoleName::class);
        $permissionId = self::createMock(PermissionId::class);
        $role = new Role($roleId, $roleName, [$permissionId]);

        $permissionId->expects(self::exactly(2))->method('isEqualTo')->with($permissionId)->willReturn(true);
        self::assertTrue($role->hasPermission($permissionId));
        $role->losePermission($permissionId);
        self::assertFalse($role->hasPermission($permissionId));
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Role\Role::__construct
     * @covers \Npl\IAM\Domain\Model\Role\Role::hasPermission
     */
    public function testHasPermission(): void
    {
        $roleId = self::createMock(RoleId::class);
        $roleName = self::createMock(RoleName::class);
        $permissionId = self::createMock(PermissionId::class);
        $secondPermissionId = self::createMock(PermissionId::class);
        $role = new Role($roleId, $roleName, [$permissionId]);

        $permissionId
            ->expects(self::exactly(2))
            ->method('isEqualTo')
            ->willReturnOnConsecutiveCalls(true, false);

        self::assertTrue($role->hasPermission($permissionId));
        self::assertFalse($role->hasPermission($secondPermissionId));
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Role\Role::__construct
     * @covers \Npl\IAM\Domain\Model\Role\Role::grantTo
     * @covers \Npl\IAM\Domain\Model\Role\Role::getRoleId
     * @covers \Npl\IAM\Domain\Model\Role\RoleId
     */
    public function testGrantTo(): void
    {
        $user = self::createMock(User::class);
        $roleName = self::createMock(RoleName::class);
        $roleId = RoleId::create();

        $user->expects(self::once())->method('receiveRole')->with($roleId);
        $role = new Role($roleId, $roleName);
        $role->grantTo($user);
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Role\Role::__construct
     * @covers \Npl\IAM\Domain\Model\Role\Role::revokeFrom
     * @covers \Npl\IAM\Domain\Model\Role\Role::getRoleId
     * @covers \Npl\IAM\Domain\Model\Role\RoleId
     */
    public function testRevokeFrom(): void
    {
        $user = self::createMock(User::class);
        $roleName = self::createMock(RoleName::class);
        $roleId = RoleId::create();

        $user->expects(self::once())->method('loseRole')->with($roleId);
        $role = new Role($roleId, $roleName);
        $role->revokeFrom($user);
    }
}
