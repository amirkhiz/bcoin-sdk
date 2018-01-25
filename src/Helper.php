<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 23.01.2018
 * Time: 17:08
 */

namespace Habil\Bcoin;

use Illuminate\Support\Str;

class Helper
{
    /**
     * Transform the keys of an array to snake case
     *
     * @param array $attributes
     *
     * @return array
     */
    public static function toSnakeCase(array $attributes)
    {
        $snakeified = [];

        foreach ($attributes as $key => $value) {
            $snakeified[Str::snake($key)] = $value;
        }

        return $snakeified;
    }

    /**
     * Transform the keys of an array to camel case
     *
     * @param array attributes
     *
     * @return array
     */
    public static function toCamelCase(array $attributes)
    {
        $camelified = [];

        foreach ($attributes as $key => $value) {
            $camelified[Str::camel($key)] = $value;
        }

        return $camelified;
    }

    /**
     * @param mixed $value
     * @param bool  $dieFlag
     * @param bool  $returnFlag
     *
     * @return mixed
     */
    public static function debug($value, $dieFlag = TRUE, $returnFlag = FALSE)
    {
        echo '<pre>';
        $return = print_r($value, $returnFlag);
        echo '</pre>';

        if ($dieFlag) {
            die();
        }

        if ($returnFlag) {
            return $return;
        }
    }
}