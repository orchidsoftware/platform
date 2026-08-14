<?php

declare(strict_types=1);

namespace Orchid\Access;

use Countable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use JsonSerializable;
use Traversable;

/**
 * A set of assigned permission states.
 *
 * This value object is stored on users and roles as a JSON map of
 * permission slugs to boolean values. Permission descriptions stay in
 * the Orchid permission registry and are not persisted here.
 *
 * @implements CastsAttributes<static, mixed>
 * @implements Arrayable<string, bool>
 */
class Permissions implements Arrayable, CastsAttributes, Countable, JsonSerializable
{
    /**
     * @param array<string, bool> $states
     */
    private array $states;

    /**
     * @param array<string, mixed> $states
     */
    public function __construct(array $states = [])
    {
        $this->states = static::normalize($states);
    }

    /**
     * Create a permission set from JSON, arrays, collections, or another set.
     */
    public static function make(mixed $permissions = []): static
    {
        return match (true) {
            $permissions instanceof static      => $permissions,
            $permissions instanceof Arrayable   => static::make($permissions->toArray()),
            $permissions instanceof Traversable => static::make(iterator_to_array($permissions)),
            is_string($permissions)             => static::make(Json::decode($permissions) ?? []),
            is_array($permissions)              => new static($permissions),
            default                             => new static,
        };
    }

    /**
     * Create an allowed permission set from registered permission definitions.
     *
     * @param iterable<array{slug: string}> $definitions
     */
    public static function fromDefinitions(iterable $definitions): static
    {
        $permissions = [];

        foreach ($definitions as $definition) {
            if (is_array($definition) && isset($definition['slug'])) {
                $permissions[$definition['slug']] = true;
            }
        }

        return new static($permissions);
    }

    /**
     * Create a permission set from the dashboard permission form payload.
     *
     * @param iterable<string, mixed>|null $permissions
     */
    public static function fromEncodedForm(?iterable $permissions): static
    {
        $states = [];

        foreach ($permissions ?? [] as $permission => $allowed) {
            $permission = base64_decode((string) $permission, true);

            if ($permission !== false) {
                $states[$permission] = $allowed;
            }
        }

        return static::make($states);
    }

    /**
     * Cast the stored JSON value into a permission set.
     *
     * @param array<string, mixed> $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return static::make($attributes[$key] ?? $value);
    }

    /**
     * Prepare the permission set for JSON storage.
     *
     * @param array<string, mixed> $attributes
     *
     * @return array<string, string|false>
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        return [$key => Json::encode(static::make($value)->toArray())];
    }

    /**
     * Determine if the permission set allows the given slug.
     */
    public function allows(string $permit): bool
    {
        foreach ($this->states as $permission => $allowed) {
            if ($allowed && Str::is($permit, $permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if the exact permission slug is active.
     */
    public function isActive(string $permission): bool
    {
        return array_key_exists($permission, $this->states) && $this->states[$permission];
    }

    /**
     * Count the active permissions.
     */
    public function count(): int
    {
        return count(array_filter($this->states));
    }

    /**
     * Determine whether no permission states are assigned.
     */
    public function isEmpty(): bool
    {
        return $this->states === [];
    }

    /**
     * @return array<string, bool>
     */
    public function toArray(): array
    {
        return $this->states;
    }

    /**
     * @return array<string, bool>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @param array<mixed> $permissions
     *
     * @return array<string, bool>
     */
    private static function normalize(array $permissions): array
    {
        $normalized = [];

        foreach ($permissions as $permission => $allowed) {
            if (! is_string($permission) || $permission === '') {
                continue;
            }

            $normalized[$permission] = static::normalizeValue($allowed);
        }

        return $normalized;
    }

    private static function normalizeValue(mixed $value): bool
    {
        return match (true) {
            is_bool($value)   => $value,
            is_string($value) => filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $value !== '',
            default           => (bool) $value,
        };
    }
}
