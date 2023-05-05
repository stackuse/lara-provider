<?php

namespace Libra\Provider\Lark\Concerns;

trait UserTrait
{
    public function getAccessUserInfo(string $code)
    {
        return $this->getClient('app')->post('/open-apis/authen/v1/access_token', [
            'json' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
            ],
        ]);
    }

    public function getMinaUserInfo(string $code)
    {
        $userToken = $this->getClient('app')->post('/open-apis/mina/v2/tokenLoginValidate', [
            'json' => [
                'code' => $code,
            ],
        ]);

        return $this->getClient('app')->get('/open-apis/authen/v1/user_info', [
            'headers' => [
                'Authorization' => 'Bearer ' . $userToken['data']['access_token'],
            ],
        ]);
    }
}
