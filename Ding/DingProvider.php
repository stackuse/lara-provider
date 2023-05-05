<?php

namespace Libra\Provider\Ding;

use Illuminate\Support\Arr;
use Libra\Provider\Ding\Concerns\UserTrait;
use Libra\Provider\Binder\Contracts\EncryptorContract;
use Libra\Provider\Binder\Contracts\ProviderContract;
use Libra\Provider\Binder\Contracts\ServerContract;

class DingProvider extends ProviderContract
{
    use UserTrait;

    public function getAccess(): Access
    {
        if (!$this->access) {
            $this->access = new Access(
                appKey: $this->config['app_key'],
                appSecret: $this->config['app_secret'],
                httpClient: $this->getClient(),
                cache: $this->getCache()
            );
        }
        return $this->access;
    }

    public function getServer(): ServerContract
    {
        if (!$this->server) {
            $this->server = new Server();
        }
        return $this->server;
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
        return array_merge(
            [
                'base_uri' => 'https://api.dingtalk.com',
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ],
            Arr::get($this->config, 'http', [])
        );
    }
}
