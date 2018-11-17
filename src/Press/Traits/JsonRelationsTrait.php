<?php

declare(strict_types=1);

namespace Orchid\Press\Traits;

trait JsonRelationsTrait
{
    /**
     * Column for relations.
     *
     * @var string
     */
    protected $jsonRelationColumn = 'options';

    /**
     * @var string
     */
    protected $jsonRelationKey = 'relations';

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
    private function jsonRelationInit(): array
    {
        $options = $this->getAttribute($this->jsonRelationColumn);

        return array_key_exists($this->jsonRelationKey, $options) ? $options[$this->jsonRelationKey] : [];
    }

    /**
     * @param array $value
     *
     * @return $this
     */
    private function jsonRelationSave(array $value)
    {
        $options = $this->jsonRelationInit();
        $options[$this->jsonRelationKey] = $value;

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

        return static::whereIn('id', $option[$name]);
    }
}
