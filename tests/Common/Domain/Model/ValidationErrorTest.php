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

namespace Tests\Common\Domain\Model;

use Npl\Common\Domain\Model\ValidationError;
use PHPUnit\Framework\TestCase;

class ValidationErrorTest extends TestCase
{
    /**
     * @covers \Npl\Common\Domain\Model\ValidationError::__construct
     * @covers \Npl\Common\Domain\Model\ValidationError::getMessage
     */
    public function testGetMessage(): void
    {
        $error = new ValidationError('Test message');
        self::assertEquals('Test message', $error->getMessage());
    }

    /**
     * @covers \Npl\Common\Domain\Model\ValidationError::__construct
     */
    public function testConstructor(): void
    {
        self::expectNotToPerformAssertions();
        new ValidationError('Constructor test');
    }
}
