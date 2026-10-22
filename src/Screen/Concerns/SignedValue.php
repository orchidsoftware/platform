<?php

declare(strict_types=1);

namespace Orchid\Screen\Concerns;

use Laravel\SerializableClosure\SerializableClosure;

/**
 * Tamper-evident wrapper for arbitrary non-Model screen property values.
 *
 * The value is captured inside a signed {@see SerializableClosure} (HMAC-protected
 * when APP_KEY is configured), so any modification of the serialized payload
 * that is sent to the client and returned for processing will cause an
 * InvalidSignatureException on deserialization.
 */
final class SignedValue
{
    /**
     * Serializable closure that preserves the original value.
     */
    public SerializableClosure $payload;

    /**
     * Wrap the value in a serializable closure for signed state storage.
     */
    public function __construct(mixed $value)
    {
        $this->payload = new SerializableClosure(static fn () => $value);
    }

    /**
     * Recover the original value from its serialized closure.
     */
    public function restore(): mixed
    {
        return ($this->payload->getClosure())();
    }
}
