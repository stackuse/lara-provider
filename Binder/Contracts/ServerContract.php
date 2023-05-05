<?php

namespace Libra\Provider\Binder\Contracts;

abstract class ServerContract
{
    abstract public function serve($query);
}
