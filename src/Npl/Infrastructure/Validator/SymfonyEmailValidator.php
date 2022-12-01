<?php

declare(strict_types=1);

namespace Npl\Infrastructure\Validator;

use InvalidArgumentException;
use Npl\Domain\Shared\Core\Validator\EmailValidator;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @implements EmailValidator<string>
 */
final class SymfonyEmailValidator implements EmailValidator
{
    private ValidatorInterface $validator;

    public function __construct()
    {
        $this->validator = Validation::createValidator();
    }

    public function validate(mixed $value): void
    {
        $errors = $this->validator->validate(
            $value,
            [new NotBlank(), new Email(['mode' => Email::VALIDATION_MODE_STRICT])]
        );

        if (0 !== count($errors)) {
            $error = $errors->get(0);
            $errorMessage = (string)$error->getMessage();
            throw new InvalidArgumentException(
                sprintf(
                    '%s Value: "%s"',
                    $errorMessage,
                    $value
                )
            );
        }
    }
}
