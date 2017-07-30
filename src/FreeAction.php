<?php
declare(strict_types=1);

namespace PollingConsumer;

use PollingConsumer\Free\{
    Free,
    Pure
};

abstract class FreeAction
{
    public const of   = self::class . '::of';
    public const free = self::class . '::free';
    public const pure = self::class . '::pure';

    final public static function of(callable $fn, $value): FreeAction
    {
        return self::free($fn, $value);
    }

    final public static function free(callable $fn, $value): FreeAction
    {
        return new Free($fn, $value);
    }

    final public static function pure($value): FreeAction
    {
        return new Pure($value);
    }

    abstract public function bind(callable $fn): FreeAction;

    abstract public function map(callable $fn): FreeAction;

    abstract public function runFree(callable $interpretation);
}
