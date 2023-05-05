<?php

namespace Libra\Provider\Wecom;

use Libra\Provider\Binder\Contracts\ServerContract;

class Server extends ServerContract
{
    public function __construct(
        protected array $queryParams,
    )
    {
    }

    public function serve()
    {

    }
}
