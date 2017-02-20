<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 20.02.17
 * Time: 11:13.
 */

namespace Orchid\Foundation\Http\Forms\Tools\Advertising;

/**
 * Class CodeOperations.
 */
trait CodeOperations
{
    /**
     * @param $code
     * @param $fullSavePath
     */
    private function saveCode($code, $fullSavePath)
    {
        $decodedCode = htmlspecialchars_decode($code);
        file_put_contents($fullSavePath, $decodedCode);
    }

    /**
     * @param $path
     * @param $code
     *
     * @return string
     */
    private function createCodePath($path, $code)
    {
        $fullSavePath = $path.'/'.md5($code).'.html';

        return $fullSavePath;
    }
}
