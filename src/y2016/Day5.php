<?php

namespace Jtgrimes\Advent\y2016;

use Illuminate\Support\Str;

class Day5 extends \Jtgrimes\Advent\Day
{
    private $input = 'abbhdwsy';
    public $part1Solution = '801b56a7';
    public $part2Solution = '424a0197';

    public function part1()
    {
        $code = '';
        $i = 1;
        while (strlen($code) < 8) {
            $md5 = md5($this->input . "$i");
            if (Str::startsWith($md5, '00000')) {
                echo("$md5\n");
                $code .= str_split($md5)[5];
            }
            $i++;
        }
        return $code;
    }

    public function part2()
    {
        $code = [];
        $i = 1;
        while (count($code) < 8) {
            $md5 = md5($this->input . "$i");
            if (Str::startsWith($md5, '00000')) {
                echo("$md5\n");
                $position = str_split($md5)[5];
                if (is_numeric($position) && $position < 8 && !array_key_exists($position, $code)) {
                    $code[$position] = str_split($md5)[6];
                    echo "Position: $position / Letter: ".$code[$position]."\n";
                }
            }
            $i++;
        }
        ksort($code);
        return implode('', $code);
    }
}