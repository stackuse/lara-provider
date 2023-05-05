<?php

namespace Libra\Provider\Wechat;

use Illuminate\Redis\Connections\Connection;
use Libra\Provider\Binder\Contracts\AccessContract;
use Libra\Provider\Binder\Http\Client;

class Access extends AccessContract
{
    public function __construct(
        protected string     $appId,
        protected string     $secret,
        protected Client     $httpClient,
        protected Connection $cache
    )
    {
    }

    public function toQuery(): array
    {
        return [
            'query' => [
                'access-token' => $this->getToken(),
            ],
        ];
    }

    public function getToken(): string
    {
        $key = $this->getCacheKey();
        if (!$token = $this->getCacheToken($key)) {
            $response = $this->httpClient->get(
                '/cgi-bin/token',
                [
                    'query' => [
                        'grant_type' => 'client_credential',
                        'appid' => $this->appId,
                        'secret' => $this->secret,
                    ],
                ]);
            $token = $response['access_token'];
            $this->setCacheToken($this->getCacheKey(), $token, $response['expires_in'] - $this->aheadExpired);
        }
        return $token;
    }

    function getCacheKey(string $suffix = ''): string
    {
        return 'wechat.access_token.' . $this->appId . $suffix;
    }
}
