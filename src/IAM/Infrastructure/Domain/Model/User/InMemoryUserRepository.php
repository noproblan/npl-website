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

namespace Npl\IAM\Infrastructure\Domain\Model\User;

use Npl\IAM\Domain\Model\Email\Email;
use Npl\IAM\Domain\Model\Email\EmailValidator;
use Npl\IAM\Domain\Model\Password\Password;
use Npl\IAM\Domain\Model\Role\RoleId;
use Npl\IAM\Domain\Model\User\User;
use Npl\IAM\Domain\Model\User\UserRepository;
use Npl\IAM\Domain\Model\User\UserSpecification;
use Npl\IAM\Infrastructure\Domain\Service\PasswordHashing\DefaultPasswordHashingFactory;
use Npl\Shared\Domain\Model\UserId;

class InMemoryUserRepository implements UserRepository
{
    /**
     * @var User[]
     */
    private array $users = [];

    public function __construct(private readonly EmailValidator $validator)
    {
        $pwFactory = new DefaultPasswordHashingFactory();
        $pw = $pwFactory->default()->hash('some');
        $this->users[] = new User(
            UserId::fromString('ee778381-17f8-44a2-90f4-194321ff0388'),
            new Email($this->validator, 'some@gmail.com'),
            new Password($pw),
            [RoleId::fromString('304c1093-faf1-4b13-87d0-1210c1991a6a')]
        );
    }

    public function ofId(UserId $anId): ?User
    {
        foreach ($this->users as $user) {
            if ($user->getUserId()->isEqualTo($anId)) {
                return $user;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        return $this->users;
    }

    /**
     * @inheritDoc
     */
    public function query(UserSpecification $specification): array
    {
        return array_filter($this->users, function ($item) use ($specification) {
            return $specification->isSatisfiedBy($item);
        });
    }

    /**
     * @inheritDoc
     */
    public function saveAll(array $users): void
    {
        foreach ($users as $user) {
            $this->save($user);
        }
    }

    public function save(User $user): void
    {
        foreach ($this->users as $index => $existingUser) {
            if ($existingUser->getUserId()->isEqualTo($user->getUserId())) {
                $this->users[$index] = $user;
                return;
            }
        }

        $this->users[] = $user;
    }

    /**
     * @inheritDoc
     */
    public function removeAll(array $users): void
    {
        foreach ($users as $user) {
            $this->remove($user);
        }
    }

    public function remove(User $anUser): void
    {
        $this->users = array_filter($this->users, static function ($element) use ($anUser) {
            return !$element->getUserId()->isEqualTo($anUser->getUserId());
        });
    }
}
