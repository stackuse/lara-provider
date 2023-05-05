<?php

namespace Libra\Provider\Kong;

use Illuminate\Redis\Connections\Connection;
use Libra\Provider\Binder\Contracts\AccessContract;
use Libra\Provider\Binder\Http\Client;

class Access extends AccessContract
{
    public function __construct(
        protected string     $nodeId,
        protected Client     $httpClient,
        protected Connection $cache
    )
    {
    }

    public function setToken(string $accessToken, int $expiresIn)
    {
        $this->cache->set($this->getCacheKey(), $accessToken, $expiresIn);
    }

    /**
     * @param string $suffix
     * @return string
     */
    public function getCacheKey(string $suffix = ''): string
    {
        return 'kong.access_token.' . $this->nodeId . $suffix;
    }

    public function toQuery(): array
    {
        return [
            'headers' => [
                'x-acs-dingtalk-access-token' => $this->getToken(),
            ],
        ];
    }

    public function getToken($code = ''): string
    {
        return 'test';
    }
}
