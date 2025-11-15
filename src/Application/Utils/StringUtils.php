<?php

namespace DevFighters\Utils\Application\Utils;

class StringUtils {

    public static function generateRandomString($length = 10) : string{
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        while(strlen($randomString) < $length) {
            $randomString .= $characters[Rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}