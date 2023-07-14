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

namespace Tests\IAM\Application\CreateUser;

use Npl\IAM\Application\CreateUser\CreateUserRequest;
use Npl\IAM\Application\CreateUser\CreateUserService;
use Npl\IAM\Application\CreateUser\UserAlreadyExistsException;
use Npl\IAM\Domain\Model\Email\Email;
use Npl\IAM\Domain\Model\Email\EmailFactory;
use Npl\IAM\Domain\Model\Password\Password;
use Npl\IAM\Domain\Model\Password\PasswordFactory;
use Npl\IAM\Domain\Model\User\User;
use Npl\IAM\Domain\Model\User\UserFactory;
use Npl\IAM\Domain\Model\User\UserRepository;
use Npl\IAM\Domain\Model\User\UserSpecification;
use Npl\IAM\Domain\Service\Specification\SpecificationFactory;
use Npl\Shared\Domain\Model\UserId;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateUserServiceTest extends TestCase
{
    private MockObject $emailFactory;
    private MockObject $passwordFactory;
    private MockObject $specFactory;
    private MockObject $userFactory;
    private MockObject $userRepository;
    private CreateUserService $service;

    /**
     * @covers \Npl\IAM\Application\CreateUser\CreateUserRequest::__construct
     * @covers \Npl\IAM\Application\CreateUser\CreateUserRequest::getEmail
     * @covers \Npl\IAM\Application\CreateUser\CreateUserRequest::getPassword
     * @covers \Npl\IAM\Application\CreateUser\CreateUserService::__construct
     * @covers \Npl\IAM\Application\CreateUser\CreateUserService::execute
     */
    public function testExecuteThrowsExceptionWhenUserAlreadyExists(): void
    {
        self::expectException(UserAlreadyExistsException::class);
        $this->userFactory->expects(self::never())->method('create');

        $email = self::createMock(Email::class);
        $this->emailFactory
            ->expects(self::once())
            ->method('fromString')
            ->with('some@email.com')
            ->willReturn($email);
        $password = self::createMock(Password::class);
        $this->passwordFactory
            ->expects(self::once())
            ->method('fromPlain')
            ->with('some_password')
            ->willReturn($password);
        $spec = self::createMock(UserSpecification::class);
        $this->specFactory
            ->expects(self::once())
            ->method('createUserByEmail')
            ->with($email)
            ->willReturn($spec);
        $user = self::createMock(User::class);
        $this->userRepository
            ->expects(self::once())
            ->method('query')
            ->with($spec)
            ->willReturn([$user]);

        $request = new CreateUserRequest('some@email.com', 'some_password');
        $this->service->execute($request);
    }

    /**
     * @covers \Npl\IAM\Application\CreateUser\CreateUserRequest::__construct
     * @covers \Npl\IAM\Application\CreateUser\CreateUserRequest::getEmail
     * @covers \Npl\IAM\Application\CreateUser\CreateUserRequest::getPassword
     * @covers \Npl\IAM\Application\CreateUser\CreateUserService::__construct
     * @covers \Npl\IAM\Application\CreateUser\CreateUserService::execute
     * @covers \Npl\IAM\Application\CreateUser\CreateUserResponse::__construct
     * @covers \Npl\IAM\Application\CreateUser\CreateUserResponse::getUserId
     */
    public function testExecuteReturnsUser(): void
    {
        $email = self::createMock(Email::class);
        $this->emailFactory
            ->expects(self::once())
            ->method('fromString')
            ->with('some@email.com')
            ->willReturn($email);
        $password = self::createMock(Password::class);
        $this->passwordFactory
            ->expects(self::once())
            ->method('fromPlain')
            ->with('some_password')
            ->willReturn($password);
        $spec = self::createMock(UserSpecification::class);
        $this->specFactory
            ->expects(self::once())
            ->method('createUserByEmail')
            ->with($email)
            ->willReturn($spec);
        $this->userRepository
            ->expects(self::once())
            ->method('query')
            ->with($spec)
            ->willReturn([]);
        $user = self::createMock(User::class);
        $this->userFactory
            ->expects(self::once())
            ->method('create')
            ->with($email, $password)
            ->willReturn($user);
        $this->userRepository
            ->expects(self::once())
            ->method('save')
            ->with($user);
        $userId = self::createMock(UserId::class);
        $user->expects(self::once())
            ->method('getUserId')
            ->willReturn($userId);
        $userId->expects(self::once())
            ->method('getValue')
            ->willReturn('The user id');

        $request = new CreateUserRequest('some@email.com', 'some_password');
        $response = $this->service->execute($request);
        self::assertEquals('The user id', $response->getUserId());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->emailFactory = self::createMock(EmailFactory::class);
        $this->passwordFactory = self::createMock(PasswordFactory::class);
        $this->specFactory = self::createMock(SpecificationFactory::class);
        $this->userFactory = self::createMock(UserFactory::class);
        $this->userRepository = self::createMock(UserRepository::class);
        $this->service = new CreateUserService(
            $this->emailFactory,
            $this->passwordFactory,
            $this->specFactory,
            $this->userFactory,
            $this->userRepository
        );
    }
}

