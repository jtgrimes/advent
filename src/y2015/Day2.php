<?php

namespace Jtgrimes\Advent\y2015;

use Jtgrimes\Advent\Day;

class Day2 extends Day
{
    public $part1Solution = '1588178';
    public $part2Solution = '3783758';

    public function part1()
    {
        $lines = $this->getInputAsArrayOfLines();
        $sqfootage = 0;
        foreach ($lines as $package) {
            $dimensions = explode('x', trim($package));
            $surface1 = $dimensions[0]  * $dimensions[1];
            $surface2 = $dimensions[0]  * $dimensions[2];
            $surface3 = $dimensions[1]  * $dimensions[2];
            $min = min($surface1, $surface2, $surface3);
            $sqfootage += 2* $surface1 + 2 * $surface2 + 2 * $surface3 + $min;
        }
        return $sqfootage;
    }

    public function part2()
    {
        $lines = $this->getInputAsArrayOfLines();
        $ribbon = 0;
        foreach ($lines as $package) {
            $dimensions = explode('x', trim($package));
            $surface1 = 2 * $dimensions[0] + 2 * $dimensions[1];
            $surface2 = 2 * $dimensions[0] + 2 * $dimensions[2];
            $surface3 = 2 * $dimensions[1] + 2 * $dimensions[2];
            $volume = $dimensions[0] * $dimensions[1] * $dimensions[2];
            $ribbon += min($surface1, $surface2, $surface3) + $volume;
        }
        return $ribbon;
    }
}