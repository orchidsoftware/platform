<?php

declare(strict_types=1);

namespace Orchid\Platform\Core\Traits;

trait JsonRelations
{
    /**
     * Column for relations.
     * @var string
     */
    public $jsonRelationColumn = 'options';

    /**
     * @param $name
     * @param $id
     *
     * @return $this
     */
    public function addJsonRelation($name, $id)
    {
        $option = $this->jsonRelationInit();

        $option[$name][] = $id;
        $option[$name] = array_unique($option[$name]);

        return $this->jsonRelationSave($option);
    }

    /**
     * @return array
     */
    private function jsonRelationInit()
    {
        $options = $this->getAttribute($this->jsonRelationColumn);

        if (array_key_exists('relations', $options)) {
            return $options['relations'];
        }

        return [];
    }

    /**
     * @param array $value
     *
     * @return $this
     */
    private function jsonRelationSave(array $value)
    {
        $options = $this->jsonRelationInit();
        $options['relations'] = $value;

        $this->setAttribute($this->jsonRelationColumn, $options);

        return $this;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function loadJsonRelation($name)
    {
        $option = $this->jsonRelationInit();

        if (! array_key_exists($name, $option)) {
            $option[$name] = [];
        }

        return self::whereIn('id', $option[$name]);
    }
}
