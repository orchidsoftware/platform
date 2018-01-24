<?php

namespace Orchid\Platform\Core\Traits;

use Illuminate\Support\Facades\App;

trait MultiLanguage
{
    /**
     * Name row localization.
     * @var string
     */
    public $jsonColumnName = 'content';

    /**
     * @param      $field
     * @param null $lang
     *
     * @return mixed|null
     */
    public function getContent($field, $lang = null)
    {
        $attributes = array_keys($this->getAttributes());

        if (in_array($field, $attributes)) {
            return $this->getAttribute($field);
        }

        $lang = $lang ?? App::getLocale();

        return collect($this->getAttribute($this->jsonColumnName))->get($lang . '.' . $field);

    }
}
