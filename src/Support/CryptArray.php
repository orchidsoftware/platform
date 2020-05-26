<?php

namespace Orchid\Support;

use Illuminate\Support\Facades\Crypt;

class CryptArray
{
    public static function encrypt(array $data): string
    {
        return Crypt::encryptString(serialize($data));
    }

    public static function decrypt(string $data): string
    {
        return Crypt::decryptString(unserialize($data));
    }
}
