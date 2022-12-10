<?php

namespace Jtgrimes\Advent\Support;

use Illuminate\Support\Str;

class StringUtility
{
    public function __construct(protected $string) {}
    public static function countMatchingStrings($input, $matchFunction)
    {
        $counter = 0;
        foreach ($input as $line) {
            if ($matchFunction($line)) {
                $counter++;
            }
        }
        return $counter;
    }

    public function charactersBetween($first, $second = '')
    {
        $firstPosition = strpos($this->string, $first) + strlen($first);
        $length = empty($second) ? null : strpos($this->string, $second) - $firstPosition;
        return Str::substr($this->string, $firstPosition, $length);
    }
}