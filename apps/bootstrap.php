<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

$rootPath = dirname(__DIR__);

require $rootPath . '/vendor/autoload.php';

if (is_array($env = @include $rootPath . '/.env.local.php')) {
    foreach ($env as $key => $value) {
        $_ENV[$key] = $_ENV[$key] ?? (isset($_SERVER[$key]) && str_starts_with(
            $key,
            'HTTP_'
        ) ? $_SERVER[$key] : $value);
    }
} elseif (!class_exists(Dotenv::class)) {
    throw new RuntimeException(
        'Please run "composer require symfony/dotenv" to load the ".env" files configuring the application.'
    );
} else {
    // load all the .env files
    (new Dotenv())->loadEnv($rootPath . '/.env');
}

$_SERVER += $_ENV;
$_SERVER['APP_ENV'] = $_ENV['APP_ENV'] = ($_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? null) ?: 'dev';
$_SERVER['APP_DEBUG'] = $_SERVER['APP_DEBUG'] ?? $_ENV['APP_DEBUG'] ?? 'prod' !== $_SERVER['APP_ENV'];
$_SERVER['APP_DEBUG'] = $_ENV['APP_DEBUG'] = (int)$_SERVER['APP_DEBUG'] || filter_var(
    $_SERVER['APP_DEBUG'],
    FILTER_VALIDATE_BOOLEAN
) ? '1' : '0';
