<?php

namespace Sergeymitr\SimpleJWT;

class Tools
{

    public static function base64DecodeUrl($string)
    {
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $string));
    }

    public static function base64EncodeUrl($string)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($string));
    }
}
