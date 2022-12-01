<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\Bus\Command;

interface CommandBus
{
    public function dispatch(Command $command): void;
}
