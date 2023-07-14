<?php

declare(strict_types=1);

namespace Tests\Hook;

use DG\BypassFinals;
use PHPUnit\Runner\BeforeTestHook;

class BypassFinalHook implements BeforeTestHook
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function executeBeforeTest(string $test): void
    {
        BypassFinals::enable();
    }
}
