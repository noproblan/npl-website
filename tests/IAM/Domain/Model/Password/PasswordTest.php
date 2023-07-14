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

namespace Tests\IAM\Domain\Model\Password;

use InvalidArgumentException;
use Npl\IAM\Domain\Model\Password\Password;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    /**
     * @covers \Npl\IAM\Domain\Model\Password\Password::__construct
     * @covers \Npl\IAM\Domain\Model\Password\Password::setValue
     * @covers \Npl\IAM\Domain\Model\Password\Password::assertNotEmpty
     */
    public function testConstruct(): void
    {
        self::expectNotToPerformAssertions();
        new Password('Valid');
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Password\Password::__construct
     * @covers \Npl\IAM\Domain\Model\Password\Password::setValue
     * @covers \Npl\IAM\Domain\Model\Password\Password::assertNotEmpty
     */
    public function testConstructThrowErrorWhenPasswordIsEmpty(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Empty password');
        new Password('');
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Password\Password::__construct
     * @covers \Npl\IAM\Domain\Model\Password\Password::setValue
     * @covers \Npl\IAM\Domain\Model\Password\Password::assertNotEmpty
     * @covers \Npl\IAM\Domain\Model\Password\Password::isEqualTo
     * @covers \Npl\IAM\Domain\Model\Password\Password::getValue
     */
    public function testIsEqualTo(): void
    {
        $passwordOne = new Password('PasswordOne');
        $passwordTwo = new Password('PasswordOne');
        $passwordThree = new Password('PasswordThree');
        self::assertTrue($passwordOne->isEqualTo($passwordTwo));
        self::assertFalse($passwordOne->isEqualTo($passwordThree));
    }

    /**
     * @covers \Npl\IAM\Domain\Model\Password\Password::__construct
     * @covers \Npl\IAM\Domain\Model\Password\Password::setValue
     * @covers \Npl\IAM\Domain\Model\Password\Password::assertNotEmpty
     * @covers \Npl\IAM\Domain\Model\Password\Password::getValue
     */
    public function testGetValue(): void
    {
        $password = new Password('GetValue');
        self::assertEquals('GetValue', $password->getValue());
    }
}

