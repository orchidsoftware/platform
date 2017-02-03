<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 03.02.17
 * Time: 11:43.
 */
if (!function_exists('is_associative')) {

    /**
     * @param $arr
     *
     * @return bool
     */
    function is_associative($arr)
    {
        if ([] === $arr) {
            return false;
        }

        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
