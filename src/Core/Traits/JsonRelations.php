<?php

namespace Orchid\Platform\Core\Traits;

use Orchid\Platform\Core\Models\Post;

trait JsonRelations
{
    /**
     * Column for relations
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

        if (key_exists('relations', $options)) {
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

        if (!key_exists($name, $option)) {
            $option[$name] = [];
        }

        return Post::whereIn('id', $option[$name]);
    }

    /*
    public function lezyJsonLoadTest(){
        $test = $pdo = DB::connection()->getPdo()->query('
    SELECT posts.* FROM posts JOIN posts as relationPost 
    ON JSON_CONTAINS(JSON_ARRAY(relationPost.options->"$.relations"), CAST(posts.id AS CHAR))
    where relationPost.id = 1
    ');

        dd($test->fetchAll());
    }
    */

}
