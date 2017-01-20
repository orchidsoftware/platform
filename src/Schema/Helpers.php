<?php

namespace Orchid\Schema;

trait Helpers
{
    /**
     * @param $namespaceModel
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function tableNameFromModel($namespaceModel)
    {
        $modelPath = app()->getNamespace().$namespaceModel;
        $modelPath = class_exists($modelPath) ? $modelPath : $namespaceModel;
        if (!class_exists($modelPath)) {
            throw new \Exception("Model {$modelPath} not exist!");
        }

        return with(new $modelPath())->getTable();
    }

    /**
     * @param $namespaceModel
     *
     * @return bool
     */
    public function isNamespaceModel($namespaceModel)
    {
        return str_contains($namespaceModel, '\\');
    }
}
