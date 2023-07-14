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

namespace Npl\IAM\Infrastructure\Domain\Model\Email;

use Npl\Common\Domain\Model\ValidationError;
use Npl\IAM\Domain\Model\Email\EmailValidator;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SymfonyEmailValidator implements EmailValidator
{
    private ValidatorInterface $validator;

    public function __construct()
    {
        $this->validator = Validation::createValidator();
    }
    /**
     * @inheritDoc
     */
    public function validate(mixed $value): array
    {
        $constraintViolations = $this->validator->validate(
            $value,
            [new NotBlank(), new Email(['mode' => Email::VALIDATION_MODE_STRICT])]
        );

        $errors = [];

        /** @var ConstraintViolation $violation */
        foreach ($constraintViolations as $violation) {
            $message = $violation->getMessage();
            $errors[] = new ValidationError($message);
        }

        return $errors;
    }
}
