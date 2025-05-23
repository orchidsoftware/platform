<?php

namespace Orchid\Screen\Concerns;

use Illuminate\Support\Arr;

trait HasTranslations
{
    /**
     * A set of attributes for the assignment
     * of which will automatically translate them.
     *
     * @var array
     */
    protected array $translations = [];

    /**
     * Mark the given attribute(s) as translatable.
     *
     * @param string|array $value
     * @return $this
     */
    public function translatable(string|array $value): static
    {
        $this->translations = collect($this->translations)
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

        $this->translations =  collect($this->translations)
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
        return in_array($attribute, $this->translations, true);
    }
}
