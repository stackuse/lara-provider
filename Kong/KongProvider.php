<?php

namespace Libra\Provider\Kong;

use Libra\Provider\Binder\Contracts\EncryptorContract;
use Libra\Provider\Binder\Contracts\ProviderContract;
use Libra\Provider\Binder\Contracts\ServerContract;

class KongProvider extends ProviderContract
{
    public function getAccess(): Access
    {
        if (!$this->access) {
            $this->access = new Access(
                nodeId: $this->config['id'] ?? 'kong',
                httpClient: $this->getHttpClient(),
                cache: $this->getCache()
            );
        }
        return $this->access;
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

    protected function getHttpClientOptions(): array
    {
        return [
            'base_uri' => rtrim($this->config['url'], '/') . '/',
            'headers' => [
                'Accept' => 'application/json',
                'apikey' => $this->config['apikey'],
            ],
        ];
    }
}
