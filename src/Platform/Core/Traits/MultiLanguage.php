<?php

namespace Orchid\Platform\Core\Traits;

use Illuminate\Config\Repository;
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
        try {
            $lang = $lang ?? App::getLocale();
            $attributes = array_keys($this->getAttributes());

            if (! is_null($this->{$this->jsonColumnName}) && ! in_array($field, $attributes)) {
                if ($this->{$this->jsonColumnName} instanceof Repository) {
                    return $this->{$this->jsonColumnName}->get($lang.'.'.$field);
                }
                return $this->{$this->jsonColumnName}[$lang][$field];
            }

            if (in_array($field, $attributes)) {
                return $this->$field;
            }
        } catch (\ErrorException $exception) {
            $content = collect($this->{$this->jsonColumnName})->first();

            if (array_key_exists($field, $content)) {
                return $content[$field];
            }
        }
    }
}
