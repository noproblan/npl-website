<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core\Authentication;

use Npl\Domain\Shared\Core\ValueObject\StringValueObject;

final class AuthEmail extends StringValueObject
{
    public function getEmail(): string
    {
        return $this->value;
    }
}
