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
        try {
            $lang = $lang ?? App::getLocale();
            $attributes = array_keys($this->getAttributes());

            if (! is_null($this->{$this->jsonColumnName}) && ! in_array($field, $attributes)) {
                if (isset($this->{$this->jsonColumnName}[$lang][$field])) {
                    return $this->{$this->jsonColumnName}[$lang][$field];
                }
                return $this->getContentByPath($this->{$this->jsonColumnName}[$lang], $field);
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

    /**
     * @param  array   $array
     * @param  string  $path
     * @return mixed
     */
    private function getContentByPath($array, $path)
    {
        list($name, $path) = explode('.', $path, 2) + [null, null];
        if (!isset($array[$name])) return;

        return $path ? $this->getContentByPath($array[$name], $path) : $array[$name];
    }
}
