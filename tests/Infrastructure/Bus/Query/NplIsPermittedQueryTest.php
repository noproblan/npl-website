<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Bus\Query;

use Npl\Infrastructure\Bus\Query\NplIsPermittedQuery;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Npl\Infrastructure\Bus\Query\NplIsPermittedQuery
 */
class NplIsPermittedQueryTest extends TestCase
{
    public function testGetResourceName(): void
    {
        $query = new NplIsPermittedQuery('name of the resource');
        static::assertEquals('name of the resource', $query->getResourceName());
    }
}
