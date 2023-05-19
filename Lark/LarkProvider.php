<?php

namespace Libra\Provider\Lark;

use Illuminate\Support\Arr;
use Libra\Provider\Binder\Contracts\EncryptorContract;
use Libra\Provider\Binder\Contracts\ProviderContract;
use Libra\Provider\Binder\Contracts\ServerContract;
use Libra\Provider\Lark\Concerns\UserTrait;

class LarkProvider extends ProviderContract
{
    use UserTrait;

    public function getAccess(): Access
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
        if (!$this->encryptor) {
            $this->encryptor = new Encryptor();
        }
        return $this->encryptor;
    }

    protected function getHttpClientOptions(): array
    {
        return array_merge(
            ['base_uri' => 'https://open.feishu.cn'],
            Arr::get($this->config, 'http', [])
        );
    }
}
