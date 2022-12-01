<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Validator;

use InvalidArgumentException;
use Npl\Infrastructure\Validator\EguliasEmailDnsValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Npl\Infrastructure\Validator\EguliasEmailDnsValidator
 */
class EguliasEmailValidatorTest extends TestCase
{
    private EguliasEmailDnsValidator $validator;

    public function testValidateThrowsIfEmailIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"" is not a valid email address. No domain part found.');
        $this->validator->validate('');
    }

    public function testValidateThrowsIfEmailIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"no mail" is not a valid email address. ATEXT found after CFWS.');
        $this->validator->validate('no mail');
    }

    public function testValidateThrowsIfEmailMXIsNotAcceptingMails(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            '"valid@example.com" is not a valid email address. Domain accepts no mail (Null MX, RFC7505).'
        );
        $this->validator->validate('valid@example.com');
    }

    public function testValidate(): void
    {
        static::expectNotToPerformAssertions();
        $this->validator->validate('admin@noproblan.ch');
    }

    protected function setUp(): void
    {
        $this->validator = new EguliasEmailDnsValidator();

        parent::setUp();
    }
}
