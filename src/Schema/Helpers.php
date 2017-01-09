<?php

namespace Orchid\Schema;

trait Helpers
{
    /**
     * @param $namespaceModel
     * @return mixed
     * @throws \Exception
     */
    public function tableNameFromModel($namespaceModel)
    {
        $modelPath = app()->getNamespace().$namespaceModel;
        $modelPath = class_exists($modelPath) ? $modelPath : $namespaceModel;
        if (! class_exists($modelPath)) {
            throw new \Exception("Model {$modelPath} not exist!");
        }

        return with(new $modelPath())->getTable();
    }

    /**
     * @param $namespaceModel
     * @return bool
     */
    public function isNamespaceModel($namespaceModel)
    {
        return str_contains($namespaceModel, '\\');
    }

    /**
     * Format bytes.
     * @param $bytes
     * @return string
     */
    public function formatBytes($bytes)
    {
        $bytes = floatval($bytes);
        $arBytes = [
            0 => [
                'UNIT' => 'TB',
                'VALUE' => pow(1024, 4),
            ],
            1 => [
                'UNIT' => 'GB',
                'VALUE' => pow(1024, 3),
            ],
            2 => [
                'UNIT' => 'MB',
                'VALUE' => pow(1024, 2),
            ],
            3 => [
                'UNIT' => 'KB',
                'VALUE' => 1024,
            ],
            4 => [
                'UNIT' => 'B',
                'VALUE' => 1,
            ],
        ];

        foreach ($arBytes as $arItem) {
            if ($bytes >= $arItem['VALUE']) {
                $result = $bytes / $arItem['VALUE'];
                $result = str_replace('.', ',', strval(round($result, 2))).' '.$arItem['UNIT'];
                break;
            }
        }

        return $result;
    }

    /**
     * Fetch queries value if key exist.
     * @param $queries
     * @param $keyString
     * @return mixed
     */
    public function getValueIfExist($queries, $keyString)
    {
        foreach ($queries as $query) {
            if ($query->Variable_name == $keyString) {
                return $query->Value;
            }
        }
    }
}
