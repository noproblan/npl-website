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

namespace Npl\IAM\Application\Login;

use Npl\IAM\Domain\Model\Email\EmailFactory;
use Npl\IAM\Domain\Model\User\UserRepository;
use Npl\IAM\Domain\Service\PasswordHashing\PasswordHashingFactory;
use Npl\IAM\Domain\Service\Specification\SpecificationFactory;

class LoginService
{
    public function __construct(
        private readonly EmailFactory $emailFactory,
        private readonly PasswordHashingFactory $hashFactory,
        private readonly UserRepository $userRepository,
        private readonly SpecificationFactory $specFactory
    ) {
    }

    public function execute(LoginRequest $request): LoginResponse
    {
        $email = $this->emailFactory->fromString($request->getEmail());

        $spec = $this->specFactory->createUserByEmail($email);
        $users = $this->userRepository->query($spec);

        if (empty($users)) {
            throw new BadCredentialsException();
        }

        $user = $users[0];
        $userPassword = $user->getPassword()->getValue();
        $hash = $this->hashFactory->fromHash($userPassword);

        if (!$hash->verify($request->getPassword(), $userPassword)) {
            throw new BadCredentialsException();
        }

        return new LoginResponse($user);
    }
}
