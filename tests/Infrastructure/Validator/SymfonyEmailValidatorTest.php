<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Validator;

use InvalidArgumentException;
use Npl\Infrastructure\Validator\SymfonyEmailValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Npl\Infrastructure\Validator\SymfonyEmailValidator
 */
class SymfonyEmailValidatorTest extends TestCase
{
    private SymfonyEmailValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new SymfonyEmailValidator();
        parent::setUp();
    }

    public function testValidateThrowsIfEmailIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('This value should not be blank. Value: ""');
        $this->validator->validate('');
    }

    public function testValidateThrowsIfEmailIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('This value is not a valid email address. Value: "no mail"');
        $this->validator->validate('no mail');
    }

    public function testValidate(): void
    {
        static::expectNotToPerformAssertions();
        $this->validator->validate('valid@example.com');
    }
}
