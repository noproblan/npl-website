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

namespace Npl\IAM\Domain\Model\Email;

use InvalidArgumentException;

use function Npl\IAM\Domain\Model\User\count;

class Email
{
    private string $value;

    public function __construct(private readonly EmailValidator $validator, string $value)
    {
        $this->setValue($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqualTo(Email $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    private function setValue(string $value): void
    {
        $this->assertNotEmpty($value);
        $this->assertValidEmailFormat($value);
        $this->value = $value;
    }

    private function assertNotEmpty(string $value): void
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Empty email');
        }
    }

    private function assertValidEmailFormat(string $value): void
    {
        $errors = $this->validator->validate($value);

        if (\count($errors) > 0) {
            $error = $errors[0];
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid email address, reason: %s',
                    $error->getMessage()
                )
            );
        }
    }
}
