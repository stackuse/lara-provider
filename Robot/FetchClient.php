<?php

namespace Libra\Provider\Robot;

use Illuminate\Cookie\CookieJar;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class FetchClient
{
    public static function create(CookieJar $cookieJar = null): HttpBrowser
    {
        $client = HttpClient::create([
            'headers' => [
                'User-Agent' => static::getUserAgent()
            ]
        ]);
        $browser = new HttpBrowser($client, null, $cookieJar);
        $browser->setServerParameters([
            'HTTP_USER_AGENT' => static::getUserAgent()
        ]);
        return $browser;
    }

    public static function getUserAgent(): string
    {
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36'
        ];

        return $userAgents[array_rand($userAgents)];
    }
}
