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

namespace Npl\IAM\Domain\Model\User;

use Npl\Shared\Domain\Model\UserId;

interface UserRepository
{
    public function ofId(UserId $anId): ?User;
    /**
     * @return User[]
     */
    public function getAll(): array;
    /**
     * @param UserSpecification $specification
     * @return User[]
     */
    public function query(UserSpecification $specification): array;
    public function save(User $user): void;

    /**
     * @param User[] $users
     * @return void
     */
    public function saveAll(array $users): void;
    public function remove(User $anUser): void;

    /**
     * @param User[] $users
     * @return void
     */
    public function removeAll(array $users): void;
}
