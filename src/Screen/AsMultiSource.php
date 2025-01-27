<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\Support\Arr;

trait AsMultiSource
{
    use AsSource {
        AsSource::getContent as getBaseContent;
    }
    /**
     * Name row localization.
     */
    public string $jsonColumnName = 'content';

    /**
     * @return mixed|null
     */
    public function getContent(string $field, ?string $locale = null): mixed
    {
        return $this->getBaseContent($field) ?? $this->getContentMultiLang($field, $locale);
    }

    /**
     * @param null $locale
     *
     * @return mixed
     */
    private function getContentMultiLang(string $field, $locale = null)
    {
        $jsonContent = (array) $this->getAttribute($this->jsonColumnName);
        $fullName = ($locale ?? app()->getLocale()).'.'.$field;
        if (Arr::has($jsonContent, $fullName)) {
            return Arr::get($jsonContent, $fullName);
        }

        return Arr::get($jsonContent, config('app.fallback_locale').'.'.$field);
    }
}
