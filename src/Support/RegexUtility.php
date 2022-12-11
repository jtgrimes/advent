<?php

namespace Jtgrimes\Advent\Support;

class RegexUtility
{
    public static function firstMatch($pattern, $input)
    {
        $matches = [];
        if (preg_match($pattern, $input, $matches)) {
            return $matches[1];
        }

    }
}