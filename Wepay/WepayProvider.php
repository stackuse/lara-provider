<?php

namespace Libra\Provider\Wepay;

use Illuminate\Support\Arr;
use Libra\Provider\Binder\Contracts\EncryptorContract;
use Libra\Provider\Binder\Contracts\ProviderContract;
use Libra\Provider\Binder\Contracts\ServerContract;

class WepayProvider extends ProviderContract
{

    public function getServer(): ServerContract
    {
        // TODO: Implement getServer() method.
    }

    public function getEncryptor(): EncryptorContract
    {
        // TODO: Implement getEncryptor() method.
    }

    protected function getHttpClientOptions(): array
    {
        return array_merge(
            ['base_uri' => 'https://api.mch.weixin.qq.com'],
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
