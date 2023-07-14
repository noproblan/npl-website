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

namespace Npl\IAM\Domain\Model\Permission;

interface PermissionRepository
{
    public function nextIdentity(): PermissionId;
    public function ofId(PermissionId $anId): ?Permission;
    /**
     * @return Permission[]
     */
    public function getAll(): array;
    /**
     * @param PermissionSpecification $specification
     * @return Permission[]
     */
    public function query(PermissionSpecification $specification): array;
    public function save(Permission $permission): void;
    /**
     * @param Permission[] $permissions
     * @return void
     */
    public function saveAll(array $permissions): void;
    public function remove(Permission $aPermission): void;
    /**
     * @param Permission[] $permissions
     * @return void
     */
    public function removeAll(array $permissions): void;
}
