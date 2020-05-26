<?php

declare(strict_types=1);

namespace Orchid\Support;

use Illuminate\Support\Facades\Crypt;

class CryptArray
{
    public static function encrypt(array $data): string
    {
        return Crypt::encryptString(serialize($data));
    }

    public static function decrypt(string $data): array
    {
        return unserialize(Crypt::decryptString($data));
    }
}
