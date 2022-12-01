<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\Criteria;

interface Filter
{
    public static function fromValues(array $values): self;

    public function toValues(): array;

    public function getType(): string;

    public function serialize(): string;
}
