<?php

namespace Jtgrimes\Advent\Support;

class Calculator
{
    public static function calculate($first, $second, $operation)
    {
        switch($operation) {
            case '+':
                return $first + $second;
            case '-':
                return $first - $second;
            case '*':
                return $first * $second;
            case '/':
                return intdiv($first, $second);
            case '=':
                return $first == $second;
            default:
                throw new \Exception("Unexpected operation: $operation");
        }
    }
}