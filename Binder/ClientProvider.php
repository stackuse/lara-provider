<?php

namespace Libra\Provider\Binder;

use Libra\Provider\Binder\Contracts\AccessContract;
use Libra\Provider\Binder\Contracts\EncryptorContract;
use Libra\Provider\Binder\Contracts\ProviderContract;
use Libra\Provider\Binder\Contracts\ServerContract;

class ClientProvider extends ProviderContract
{
    protected array $httpClientOptions = [];

    public function getAccess(): AccessContract
    {
    }

    public function getServer(): ServerContract
    {
    }

    public function checkConfig(array $config)
    {
        // TODO: Implement checkConfig() method.
    }

    public function getEncryptor(): EncryptorContract
    {
        // TODO: Implement getEncryptor() method.
    }

    protected function setHttpClientOptions(array $options)
    {
        $this->httpClientOptions = $options;
    }

    protected function getHttpClientOptions(): array
    {
        return $this->httpClientOptions;
    }
}
