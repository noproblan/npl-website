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

namespace Npl\IAM\Domain\Model\Role;

interface RoleRepository
{
    public function nextIdentity(): RoleId;
    public function ofId(RoleId $anId): ?Role;
    /**
     * @return Role[]
     */
    public function getAll(): array;
    /**
     * @param RoleSpecification $specification
     * @return Role[]
     */
    public function query(RoleSpecification $specification): array;
    public function save(Role $role): void;
    /**
     * @param Role[] $roles
     * @return void
     */
    public function saveAll(array $roles): void;
    public function remove(Role $aRole): void;
    /**
     * @param Role[] $roles
     * @return void
     */
    public function removeAll(array $roles): void;
}
