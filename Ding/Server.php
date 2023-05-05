<?php

namespace Libra\Provider\Ding;

use Libra\Provider\Binder\Contracts\ServerContract;

class Server extends ServerContract
{
    public function __construct(
        protected array $config
    )
    {
    }

    public function serve($query)
    {
        $this->decryptRequestMessage($query);
    }

    protected function decryptRequestMessage($query)
    {

    }
}
