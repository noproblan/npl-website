<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Configuration;

use InvalidArgumentException;
use Npl\Infrastructure\Configuration\FileConfig;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Npl\Infrastructure\Configuration\FileConfig
 */
class FileConfigTest extends TestCase
{
    public function testConstructThrowsWhenConfigFileNotFound(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('File "config.php" does not exist!');

        new FileConfig('config.php');
    }

    public function testGetConfigThrowsWhenConfigKeyIsNotSet(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Config for "invalid key" not found!');
        $configPath = dirname(__FILE__) . '/config.test.php';
        $config = new FileConfig($configPath);
        $config->getConfig('invalid key');
    }

    public function testGetConfig(): void
    {
        $configPath = dirname(__FILE__) . '/config.test.php';
        $config = new FileConfig($configPath);
        static::assertEquals('some value', $config->getConfig('some key'));
    }
}
