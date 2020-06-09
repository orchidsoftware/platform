<?php

declare(strict_types=1);

namespace Orchid\Access;

use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuth implements TwoFactorEngine
{
    /**
     * @var Google2FA
     */
    protected $google2fa;

    /**
     * @var string
     */
    protected $secretKey;

    /**
     * TwoFactorGenerator constructor.
     */
    public function __construct()
    {
        $this->google2fa = new Google2FA();
        $this->secretKey = $this->google2fa->generateSecretKey();
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function setSecretKey(string $key): self
    {
        $this->secretKey = $key;
        $this->google2fa->setSecret($key);

        return $this;
    }

    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * Return a QR code url.
     *
     * @param string $company
     * @param string $email
     *
     * @return string
     */
    public function getQrCode(string $company, string $email): string
    {
        $qrCodeUrl = $this->google2fa->getQRCodeUrl($company, $email, $this->getSecretKey());

        $writer = new Writer(
            new ImageRenderer(
                new RendererStyle(200),
                new ImagickImageBackEnd()
            )
        );

        $quCodeImage = base64_encode($writer->writeString($qrCodeUrl));

        return 'data:image/png;base64,'.$quCodeImage;
    }

    /**
     * Verify a two-factor authentication token for the given user.
     *
     * @param string $token
     *
     * @return bool
     */
    public function verify(string $token): bool
    {
        try {
            return $this->google2fa->verify($token, $this->getSecretKey(), 8);
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * Get the current one time password for a key.
     *
     * @return string|null
     */
    public function currentCode(): ?string
    {
        try {
            return $this->google2fa->getCurrentOtp($this->getSecretKey());
        } catch (\Exception $exception) {
            return null;
        }
    }
}
