<?php

namespace Libra\Provider\Ding\Concerns;

trait UserTrait
{
    public function getUserInfo(string $code): array
    {
        return $this->getClient('user')->setAccessProps('auth_code', $code)->get('/v1.0/contact/users/me');
    }
}
