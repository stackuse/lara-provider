<?php

namespace Libra\Provider\Binder\Contracts;

abstract class EncryptorContract
{
    abstract public function decrypt(string $encrypted): string;
}
