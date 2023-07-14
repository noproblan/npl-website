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

namespace Npl\IAM\Application\CreateUser;

use Npl\IAM\Domain\Model\Email\EmailFactory;
use Npl\IAM\Domain\Model\Password\PasswordFactory;
use Npl\IAM\Domain\Model\User\User;
use Npl\IAM\Domain\Model\User\UserFactory;
use Npl\IAM\Domain\Model\User\UserRepository;
use Npl\IAM\Domain\Service\Specification\SpecificationFactory;
use Npl\Shared\Domain\Model\UserId;

class CreateUserService
{
    public function __construct(
        private readonly EmailFactory $emailFactory,
        private readonly PasswordFactory $passwordFactory,
        private readonly SpecificationFactory $specFactory,
        private readonly UserFactory $userFactory,
        private readonly UserRepository $userRepository
    ) {
    }

    public function execute(CreateUserRequest $request): CreateUserResponse
    {
        $email = $this->emailFactory->fromString($request->getEmail());
        $password = $this->passwordFactory->fromPlain($request->getPassword());

        $spec = $this->specFactory->createUserByEmail($email);
        $users = $this->userRepository->query($spec);

        if (!empty($users)) {
            throw new UserAlreadyExistsException();
        }

        $user = $this->userFactory->create(
            $email,
            $password
        );

        $this->userRepository->save($user);

        return new CreateUserResponse($user);
    }
}
