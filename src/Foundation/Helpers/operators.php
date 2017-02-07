<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 07.02.17
 * Time: 13:40
 */

if (!function_exists('like_match')) {

    /**
     * @param $pattern
     * @param $subject
     * @return bool
     */
    function like_match($pattern, $subject)
    {
        $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
        return (bool) preg_match("/^{$pattern}$/i", $subject);
    }
}