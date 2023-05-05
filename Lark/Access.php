<?php

namespace Libra\Provider\Lark;

use Illuminate\Redis\Connections\Connection;
use Libra\Provider\Binder\Contracts\AccessContract;
use Libra\Provider\Binder\Http\Client;

class Access extends AccessContract
{
    public function __construct(
        protected string     $appId,
        protected string     $appSecret,
        protected Client     $httpClient,
        protected Connection $cache
    )
    {
    }

    public function toQuery(): array
    {
        return [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getToken(),
            ],
        ];
    }

    public function getToken(): string
    {
        $key = $this->getCacheKey();
        $token = $this->getCacheToken($key);
        if (!$token) {
            $response = $this->httpClient->post('/open-apis/auth/v3/app_access_token/internal',
                [
                    'json' => [
                        'app_id' => $this->appId,
                        'app_secret' => $this->appSecret,
                    ],
                ]
            );
            $token = [
                'app' => $response['app_access_token'],
                'tenant' => $response['tenant_access_token'],
            ];
            $this->setCacheToken($key, json_encode($token), $response['expire'] - $this->aheadExpired);
        } else {
            $token = json_decode($token, true);
        }
        return $token[$this->getProp('token_type')];
    }

    /**
     * @param string $suffix
     * @return string
     */
    public function getCacheKey(string $suffix = ''): string
    {
        return 'lark.access_token.' . $this->appId . $suffix;
    }

}
