<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core;

use DomainException;

abstract class DomainError extends DomainException
{
    public function __construct()
    {
        parent::__construct($this->getErrorMessage());
    }

    abstract protected function getErrorMessage(): string;

    abstract public function getErrorCode(): string;
}
