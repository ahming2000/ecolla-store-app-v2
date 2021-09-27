<?php

namespace App\Util;

class Utility
{
    public static function getStringBetween($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public static function getFileExtension($fileName): string
    {
        $array = explode('.', $fileName);
        return end($array);
    }
}
