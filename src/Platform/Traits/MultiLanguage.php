<?php

declare(strict_types=1);

namespace Orchid\Platform\Traits;

trait MultiLanguage
{
    /**
     * Name row localization.
     *
     * @var string
     */
    public $jsonColumnName = 'content';

    /**
     * @param      $field
     * @param null $locale
     *
     * @return mixed|null
     */
    public function getContent($field, $locale = null)
    {
        $attributes = array_keys($this->toArray());

        if (in_array($field, $attributes)) {
            return $this->getAttribute($field);
        }

        $jsonContent = (array) $this->getAttribute($this->jsonColumnName);
        $fullName = ($locale ?? app()->getLocale()).'.'.$field;

        if (array_has($jsonContent, $fullName)) {
            return array_get($jsonContent, $fullName);
        }

        return array_get($jsonContent, config('app.fallback_locale').'.'.$field);
    }
}
