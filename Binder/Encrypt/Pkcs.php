<?php

namespace Libra\Provider\Binder\Encrypt;

class Pkcs
{
    public static function padding(string $contents, int $blockSize): string
    {
        $padding = $blockSize - (strlen($contents) % $blockSize);
        $pattern = chr($padding);

        return $contents . str_repeat($pattern, $padding);
    }

    public static function unpadding(string $contents, int $blockSize): string
    {
        $pad = ord(substr($contents, -1));
        if ($pad < 1 || $pad > $blockSize) {
            $pad = 0;
        }
        return substr($contents, 0, (strlen($contents) - $pad));
    }
}
