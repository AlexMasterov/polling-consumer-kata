<?php
declare(strict_types=1);

namespace PollingConsumer\Free;

use PollingConsumer\FreeAction;

final class Free extends FreeAction
{
    public function bind(callable $fn): FreeAction
    {
        return new self(
            function ($result) use ($fn) {
                return ($this->fn)($result)->bind($fn);
            },
            $this->value
        );
    }

    public function map(callable $fn): FreeAction
    {
        return new self(
            function ($result) use ($fn) {
                return ($this->fn)($result)->map($fn);
            },
            $this->value
        );
    }

    public function runFree(callable $interpretation)
    {
        return $interpretation($this->value)
            ->bind(function ($result) use ($interpretation) {
                return ($this->fn)($result)->runFree($interpretation);
            });
    }

    protected function __construct(callable $fn, $value)
    {
        $this->fn = $fn;
        $this->value = $value;
    }

    /**
     * @var callable
     */
    private $fn = null;

    /**
     * @var mixed
     */
    private $value = null;
}
