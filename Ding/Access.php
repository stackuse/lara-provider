<?php

namespace Libra\Provider\Ding;

use Illuminate\Redis\Connections\Connection;
use Libra\Provider\Binder\Contracts\AccessContract;
use Libra\Provider\Binder\Http\Client;

class Access extends AccessContract
{
    public function __construct(
        protected string     $appKey,
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
                'x-acs-dingtalk-access-token' => $this->getToken(),
            ],
        ];
    }

    public function getToken($code = ''): string
    {
        return match ($this->getProp('token_type')) {
            'user' => $this->getUserToken(),
            'corp' => $this->getCorpToken(),
            default => $this->getAppToken()
        };
    }

    public function getUserToken(): string
    {
        $response = $this->httpClient->post('/v1.0/oauth2/userAccessToken',
            [
                'headers' => [
                    'x-acs-dingtalk-access-token' => $this->getAppToken(),
                ],
                'json' => [
                    'clientId' => $this->appKey,
                    'clientSecret' => $this->appSecret,
                    'code' => $this->getProp('auth_code'),
                    'grantType' => 'authorization_code',
                ],
            ]
        );
        return $response['accessToken'];
    }

    public function getAppToken()
    {
        $key = $this->getCacheKey('app');
        if (!$token = $this->getCacheToken($key)) {
            $response = $this->httpClient->post('/v1.0/oauth2/accessToken',
                [
                    'json' => [
                        'appKey' => $this->appKey,
                        'appSecret' => $this->appSecret,
                    ],
                ]
            );
            $token = $response['accessToken'];
            $this->setCacheToken($key, $token, $response['expireIn'] - $this->aheadExpired);
        }
        return $token;
    }

    /**
     * @param string $suffix
     * @return string
     */
    public function getCacheKey(string $suffix = ''): string
    {
        return 'ding.access_token.' . $this->appKey . $suffix;
    }

    public function getCorpToken()
    {
        $key = $this->getCacheKey('app');
        if (!$token = $this->getCacheToken($key)) {
            $response = $this->httpClient->post('/v1.0/oauth2/accessToken',
                [
                    'json' => [
                        'appKey' => $this->appKey,
                        'appSecret' => $this->appSecret,
                    ],
                ]
            );
            $token = $response['accessToken'];
            $this->setCacheToken($key, $token, $response['expireIn'] - $this->aheadExpired);
        }
        return $token;
    }
}
