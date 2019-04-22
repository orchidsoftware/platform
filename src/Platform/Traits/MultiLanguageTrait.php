<?php

declare(strict_types=1);

namespace Orchid\Platform\Traits;

use Orchid\Screen\Traits\AsSource;

trait MultiLanguageTrait
{
    use AsSource {
        getContent as getBaseContent;
    }
    /**
     * Name row localization.
     *
     * @var string
     */
    public $jsonColumnName = 'content';

    /**
     * @param string $field
     * @param null $locale
     *
     * @return mixed|null
     */
    public function getContent(string $field, $locale = null)
    {
        return $this->getBaseContent($field) ?? $this->getContentMultiLang($field, $locale);
    }

    /**
     * @param string $field
     * @param null $locale
     *
     * @return mixed
     */
    private function getContentMultiLang(string $field, $locale = null)
    {
        $jsonContent = (array)$this->getAttribute($this->jsonColumnName);
        $fullName    = ($locale ?? app()->getLocale()) . '.' . $field;

        if (array_has($jsonContent, $fullName)) {
            return array_get($jsonContent, $fullName);
        }

        return array_get($jsonContent, config('app.fallback_locale') . '.' . $field);
    }
}
