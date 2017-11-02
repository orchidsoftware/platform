<?php

namespace Orchid\Platform\Core\Traits;

use Illuminate\Support\Facades\App;

trait MultiLanguage
{
    /**
     * Name row localization
     * @var string
     */
    public $rowName = 'content';

    /**
     * @param      $field
     * @param null $lang
     *
     * @return mixed|null
     */
    public function getContent($field, $lang = null)
    {
        try {
            $lang = $lang ?? App::getLocale();
            if (!is_null($this->{$this->rowName}) && !in_array($field, $this->getFillable())) {
                return $this->{$this->rowName}[$lang][$field];
            } elseif (in_array($field, $this->getFillable())) {
                return $this->$field;
            }
        } catch (\ErrorException $exception) {
            $content = collect($this->{$this->rowName})->first();

            if (array_key_exists($field, $content)) {
                return $content[$field];
            }
        }
    }
}
