<?php

namespace Libra\Provider\Wechat;

use Illuminate\Support\Arr;
use Libra\Provider\Binder\Contracts\EncryptorContract;
use Libra\Provider\Binder\Contracts\ProviderContract;
use Libra\Provider\Binder\Contracts\ServerContract;
use Libra\Provider\Wechat\Concerns\SessionTrait;

class WechatProvider extends ProviderContract
{
    use SessionTrait;

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
            ['base_uri' => 'https://api.weixin.qq.com'],
            Arr::get($this->config, 'http', [])
        );
    }

    protected function getAccess(): Access
    {
        if (!$this->access) {
            $this->access = new Access(
                appId: $this->config['app_id'],
                secret: $this->config['secret'],
                httpClient: $this->getClient(),
                cache: $this->getCache()
            );
        }
        return $this->access;
    }
}
