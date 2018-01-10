<?php

namespace Orchid\Platform\Core\Traits;

use Illuminate\Support\Facades\App;
use Orchid\Platform\Screen\Repository;

trait MultiLanguage
{
    /**
     * Name row localization.
     * @var string
     */
    public $jsonColumnName = 'content';

    /**
     * @var Repository
     */
    private $repository;

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
                return $this->getRepository($this->{$this->jsonColumnName})->get($lang . '.' . $field);
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
     * @return Repository
     */
    private function getRepository($array)
    {
        if (!$this->repository) {
            $this->repository = new Repository($array);
        }
        return $this->repository;
    }
}
