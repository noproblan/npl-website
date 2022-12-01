<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\Bus\Event;

interface EventBus
{
    public function publish(DomainEvent ...$events): void;
}
