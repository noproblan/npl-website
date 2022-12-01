<?php

declare(strict_types=1);

namespace Npl\Infrastructure\Validator;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\Extra\SpoofCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\NoRFCWarningsValidation;
use InvalidArgumentException;
use Npl\Domain\Shared\Core\Validator\EmailDNSValidator;

final class EguliasEmailDnsValidator implements EmailDNSValidator
{
    private EmailValidator $validator;
    private MultipleValidationWithAnd $validations;

    public function __construct()
    {
        $this->validator = new EmailValidator();
        $this->validations = new MultipleValidationWithAnd(
            [new NoRFCWarningsValidation(), new DNSCheckValidation(), new SpoofCheckValidation()]
        );
    }

    public function validate($value): void
    {
        $isValid = $this->validator->isValid(
            $value,
            $this->validations
        );

        if (!$isValid) {
            $error = $this->validator->getError();
            $reason = null !== $error ? $error->reason()->description() : 'No specific reason';
            throw new InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid email address. %s.',
                    $value,
                    $reason
                )
            );
        }
    }
}
