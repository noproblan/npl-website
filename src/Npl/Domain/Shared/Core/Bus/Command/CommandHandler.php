<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\Bus\Command;

/**
 * @template T
 */
interface CommandHandler
{
    /**
     * @param T $command
     * @return void
     */
    public function __invoke(mixed $command): void;
}
