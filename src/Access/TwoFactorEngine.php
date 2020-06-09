<?php

declare(strict_types=1);

namespace Orchid\Access;

interface TwoFactorEngine
{
    /**
     * @param string $key
     *
     * @return TwoFactorEngine
     */
    public function setSecretKey(string $key): TwoFactorEngine;

    /**
     * @return string
     */
    public function getSecretKey(): string;

    /**
     * Return a QR code url.
     *
     * @param string $company
     * @param string $email
     *
     * @return string
     */
    public function getQrCode(string $company, string $email): string;

    /**
     * Verify a two-factor authentication token for the given user.
     *
     * @param string $token
     *
     * @return bool
     */
    public function verify(string $token): bool;

    /**
     * Get the current one time password for a key.
     *
     * @return string|null
     */
    public function currentCode(): ?string;
}
