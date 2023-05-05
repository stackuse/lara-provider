<?php

namespace Libra\Provider\Binder\Http;

use Libra\Provider\Binder\Contracts\AccessContract;
use Libra\Provider\Binder\Traits\PropsTrait;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Throwable;

class Client
{
    use PropsTrait;

    protected HttpClientInterface $httpClient;
    protected ?AccessContract $access;
    protected bool $toArray;

    public function __construct(HttpClientInterface $httpClient, ?AccessContract $access = null, $toArray = true)
    {
        $this->httpClient = $httpClient;
        $this->access = $access;
        $this->toArray = $toArray;
    }

    public function setAccessProps(string $name, mixed $value): static
    {
        $this->access->setProp($name, $value);
        return $this;
    }

    /**
     * @param array<string, mixed> $options
     * @throws BadRequestHttpException
     */
    public function get(string $url, array $options = []): ResponseInterface|array
    {
        return $this->request('GET', $url, $options);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @return ResponseInterface|array
     * @throws BadRequestHttpException
     */
    public function request(string $method, string $url, array $options = []): ResponseInterface|array
    {
        // 有不同的access token
        if ($this->access) {
            $this->httpClient = $this->httpClient->withOptions($this->access->toQuery());
        }
        try {
            $response = $this->httpClient->request($method, ltrim($url, '/'), $options);
            if ($this->toArray) {
                return $response->toArray();
            }
            return $response;
        } catch (Throwable) {
            // 更有用的提示
            throw new BadRequestHttpException(!empty($response) ? $response->getContent(false) : '未知请求错误');
        }
    }

    public function withOptions(array $options): HttpClientInterface
    {
        return $this->httpClient->withOptions($options);
    }

    /**
     * @param array<string, mixed> $options
     * @throws BadRequestHttpException
     */
    public function post(string $url, array $options = []): ResponseInterface|array
    {
        if (!array_key_exists('body', $options) && !array_key_exists('json', $options)) {
            $options['body'] = $options;
        }
        return $this->request('POST', $url, $options);
    }

    /**
     * @param array<string, mixed> $options
     * @throws BadRequestHttpException
     */
    public function patch(string $url, array $options = []): ResponseInterface|array
    {
        if (!array_key_exists('body', $options) && !array_key_exists('json', $options)) {
            $options['body'] = $options;
        }
        return $this->request('PATCH', $url, $options);
    }

    /**
     * @param array<string, mixed> $options
     * @throws BadRequestHttpException
     */
    public function put(string $url, array $options = []): ResponseInterface|array
    {
        if (!array_key_exists('body', $options) && !array_key_exists('json', $options)) {
            $options['body'] = $options;
        }
        return $this->request('PUT', $url, $options);
    }

    /**
     * @param array<string, mixed> $options
     * @throws BadRequestHttpException
     */
    public function delete(string $url, array $options = []): ResponseInterface|array
    {
        return $this->request('DELETE', $url, $options);
    }
}
