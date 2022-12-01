<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\Validator;

/**
 * @template T
 */
interface Validator
{
    /**
     * @param T $value
     * @return void
     */
    public function validate(mixed $value): void;
}
