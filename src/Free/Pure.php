<?php
declare(strict_types=1);

namespace PollingConsumer\Free;

use PollingConsumer\FreeAction;

final class Pure extends FreeAction
{
    public function bind(callable $fn): FreeAction
    {
        return $fn($this->value);
    }

    public function map(callable $fn): FreeAction
    {
        return new self($fn($this->value));
    }

    public function runFree(callable $interpretation)
    {
        return $this->value;
    }

    protected function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @var mixed
     */
    private $value = null;
}
