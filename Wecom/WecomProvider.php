<?php

namespace Libra\Provider\Wecom;

use Illuminate\Support\Arr;
use Libra\Provider\Binder\Contracts\EncryptorContract;
use Libra\Provider\Binder\Contracts\ProviderContract;
use Libra\Provider\Binder\Contracts\ServerContract;

class WecomProvider extends ProviderContract
{
    public function getServer(): ServerContract
    {
        // TODO: Implement getServer() method.
    }

    public function getEncryptor(): EncryptorContract
    {
        // TODO: Implement getEncryptor() method.
    }

    public function checkConfig(array $config)
    {
        // TODO: Implement checkConfig() method.
    }

    protected function getHttpClientOptions(): array
    {
        return array_merge(
            ['base_uri' => 'https://qyapi.weixin.qq.com/',],
            Arr::get($this->config, 'http', [])
        );
    }

    protected function getAccess(): Access
    {

        if (!$this->access) {
            $this->access = new Access(
                appId: $this->config['app_id'],
                appSecret: $this->config['app_secret'],
                httpClient: $this->getClient(),
                cache: $this->getCache()
            );
        }
        return $this->access;
    }
}
