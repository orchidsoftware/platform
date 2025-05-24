<?php

namespace Orchid\Screen\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

trait HasTranslations
{
    /**
     * Mark the given attribute(s) as translatable.
     *
     * @param string|array $value
     * @return $this
     */
    public function translatable(string|array $value): static
    {
        $this->translations = $this->translations()
            ->merge(Arr::wrap($value))
            ->unique()
            ->toArray();

        return $this;
    }

    /**
     * Exclude the given attribute(s) from being translated.
     *
     * @param string|array|null $value
     * @return $this
     */
    public function withoutTranslation(string|array $value = null): static
    {
        if (empty($value)) {
            $this->translations = [];

            return $this;
        }

        $this->translations =  $this->translations()
            ->reject(fn ($item) => in_array($item, Arr::wrap($value), true))
            ->toArray();

        return $this;
    }

    /**
     * Determine whether the given attribute should be translated.
     *
     * @param string $attribute
     * @return bool
     */
    public function shouldTranslate(string $attribute): bool
    {
        return $this->translations()->contains($attribute);
    }

    /**
     * Get the list of translatable attributes.
     *
     * @return Collection
     */
    protected function translations(): Collection
    {
        return collect($this->translations ?? []);
    }
}
