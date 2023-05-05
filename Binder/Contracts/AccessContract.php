<?php

namespace Libra\Provider\Binder\Contracts;

use Libra\Provider\Binder\Traits\PropsTrait;

abstract class AccessContract
{
    use PropsTrait;

    protected int $aheadExpired = 600;

    /**
     * 获取缓存token的key
     * @return string
     */
    abstract function getCacheKey(): string;

    function getCacheToken(string $key): string|null
    {
        return $this->cache->get($key);
    }

    function setCacheToken(string $key, string $token, int $expiresIn): void
    {
        $this->cache->set($key, $token, 'EX', $expiresIn);
    }

    /**
     * 获取token
     * @return string
     */
    abstract public function getToken(): string;

    /**
     * @return array<string,string>
     */

    /**
     * 将token转化为请求的参数
     * @return array
     */
    abstract public function toQuery(): array;
}
