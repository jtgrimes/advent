<?php

namespace Jtgrimes\Advent\y2017;

class Day1 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = '1203';
    public $part2Solution = '1146';

    public function part1()
    {
        $chars = $this->getInputAsArrayOfCharacters();
        $runningTotal = 0;
        foreach ($chars as $i => $c) {
            $compareTo = $i == 0 ? count($chars) -1 : $i - 1;
            if ($c == $chars[$compareTo]) {
                $runningTotal += (int)$c;
            }
        }
        return $runningTotal;
    }

    public function part2()
    {
        $chars = $this->getInputAsArrayOfCharacters();
        $runningTotal = 0;
        $charCount = count($chars);
        foreach ($chars as $i => $c) {
            $compareTo = ($i + $charCount /2) % $charCount;
            if ($c == $chars[$compareTo]) {
                $runningTotal += (int)$c;
            }
        }
        return $runningTotal;
    }
}