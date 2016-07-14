<?php

/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 13-7-2016
 * Time: 17:43
 *
 * This class contain useful methods to make debugging easier.
 */
class Debugging
{
    /**
     * printItemAsArray()
     * Not sure about the name yet. But i use this method a lot for debugging.
     * @param $item can anything e.g. a POST/GET Request or something else we get from a database request.
     */
    public static function printItemAsArray($item) {
        echo "<pre>" . print_r($item, true) . "</pre>";
        exit();
    }

    // More methods will be added later
}