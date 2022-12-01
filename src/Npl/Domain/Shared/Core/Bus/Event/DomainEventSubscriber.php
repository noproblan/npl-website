<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\Bus\Event;

interface DomainEventSubscriber
{
    public static function subscribedTo(): array;
}
