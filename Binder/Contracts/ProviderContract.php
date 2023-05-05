<?php

namespace Libra\Provider\Binder\Contracts;

use Illuminate\Redis\Connections\Connection;
use Illuminate\Support\Facades\Redis;
use Libra\Provider\Binder\Http\Client;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class ProviderContract
{
    protected ?Client $client = null;

    protected ?ServerContract $server = null;

    protected ?AccessContract $access = null;

    protected ?EncryptorContract $encryptor = null;

    protected array $config;

    public function __construct(array $config)
    {
        // @todo check config
        // $this->checkConfig($config);
        $this->config = $config;
    }

    /**
     * 获取http客户端
     * @param string $tokenType
     * @param bool $toArray
     * @return Client
     */
    public function getClient(string $tokenType = '', bool $toArray = true): Client
    {
        if (!$this->client) {
            $access = $tokenType ? $this->getAccess() : null;
            $this->client = new Client($this->getHttpClient(), $access, $toArray);
        }
        if ($tokenType) {
            $this->client->setAccessProps('token_type', $tokenType);
        }
        return $this->client;
    }

    abstract protected function getAccess(): AccessContract;

    /**
     * @return HttpClientInterface
     */
    protected function getHttpClient(): HttpClientInterface
    {
        $options = $this->getHttpClientOptions();
        return HttpClient::create($options);
    }

    abstract protected function getHttpClientOptions(): array;

    /**
     * @return Connection
     */
    public function getCache(): Connection
    {
        return Redis::connection('share');
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config): static
    {
        $this->config = $config;
        return $this;
    }

    abstract public function getServer(): ServerContract;

    abstract public function getEncryptor(): EncryptorContract;

    // abstract public function checkConfig(array $config);
}
