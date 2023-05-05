<?php

namespace Libra\Provider\Binder\Traits;

trait PropsTrait
{
    protected array $props = [];

    /**
     * @param string $name
     * @return mixed
     */
    public function getProp(string $name): mixed
    {
        return $this->props[$name] ?? null;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function setProp(string $name, mixed $value): static
    {
        $this->props[$name] = $value;
        return $this;
    }
}
