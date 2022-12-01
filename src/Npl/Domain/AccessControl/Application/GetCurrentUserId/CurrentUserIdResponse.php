<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Application\GetCurrentUserId;

use Npl\Domain\Shared\Core\Bus\Query\Response;

final class CurrentUserIdResponse implements Response
{
    public function __construct(private readonly int $userId)
    {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
