<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\Criteria;

use UnexpectedValueException;

final class FilterFactory
{
    private static array $instances = [];

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        $class = self::class;

        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new self();
        }

        return self::$instances[$class];
    }

    public static function fromValues(array $values): Filter
    {
        if (
            array_key_exists(
                'filterType',
                $values
            )
        ) {
            $result = call_user_func(
                $values['filterType'] . '::fromValues',
                $values
            );
        } elseif (
            array_key_exists(
                'filters',
                $values
            ) && array_key_exists(
                'compositeType',
                $values
            )
        ) {
            $result = call_user_func(
                CompositeFilter::class . '::fromValues',
                $values
            );
        } elseif (
            array_key_exists(
                'field',
                $values
            ) && array_key_exists(
                'operator',
                $values
            ) && array_key_exists(
                'value',
                $values
            )
        ) {
            $result = call_user_func(
                ValueFilter::class . '::fromValues',
                $values
            );
        } else {
            throw new UnexpectedValueException(
                'Could not create a filter from provided values: ' . json_encode(
                    $values,
                    JSON_FORCE_OBJECT
                )
            );
        }

        return $result;
    }

    private function __clone()
    {
    }
}
