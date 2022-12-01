<?php

declare(strict_types=1);

namespace Npl\Infrastructure\Configuration;

use InvalidArgumentException;
use Npl\Domain\Shared\Core\Configuration\ConfigService;

class FileConfig implements ConfigService
{
    private $config;

    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new InvalidArgumentException(sprintf('File "%s" does not exist!', $path));
        }

        $this->config = include $path;
    }

    public function getConfig($name)
    {

        if (!array_key_exists($name, $this->config)) {
            throw new InvalidArgumentException(sprintf('Config for "%s" not found!', $name));
        }

        return $this->config[$name];
    }
}
