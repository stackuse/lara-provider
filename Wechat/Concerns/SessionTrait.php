<?php

namespace Libra\Provider\Wechat\Concerns;

trait SessionTrait
{
    public function session(string $code): array
    {
        $options = [
            'query' => [
                'appid' => $this->config['app_id'],
                'secret' => $this->config['secret'],
                'js_code' => $code,
                'grant_type' => 'authorization_code',
            ],
        ];
        return $this->getClient()->get('/sns/jscode2session', $options);
    }
}
