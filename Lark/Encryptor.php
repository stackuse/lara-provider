<?php

namespace Libra\Provider\Lark;

use Error;
use Libra\Provider\Binder\Contracts\EncryptorContract;

class Encryptor extends EncryptorContract
{
    /**
     * AES key.
     *
     * @var string
     */
    protected string $encryptKey;

    /**
     * Constructor.
     *
     * @param string $encryptKey
     */
    public function __construct(string $encryptKey)
    {
        $this->encryptKey = $encryptKey;
    }

    public function decrypt(string $encrypted): string
    {
        try {
            $key = hash('sha256', $this->encryptKey, true);
            $ciphertext = base64_decode($encrypted, true);
            $iv = substr($key, 0, 16);
            $decrypted = openssl_decrypt($ciphertext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);

            return substr($decrypted, 16);
        } catch (Error) {

        }
    }
}
