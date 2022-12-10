<?php

namespace Jtgrimes\Advent\y2021;

class Day1 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = '1502';
    public $part2Solution = '1538';
    public function part1()
    {
        $lines = $this->getInputAsArrayOfLines();
        $increases = 0;
        foreach ($lines as $i => $line) {
            if ($i == 0) {
                // do nothing
            } else {
                if ((int)$line > (int)$lines[$i-1]) {
                    $increases++;
                }
            }
        }
        return $increases;
    }

    public function part2()
    {
        $lines = $this->getInputAsArrayOfLines();
        $increases = 0;
        foreach ($lines as $i => $line) {
            if ($i < 3) {
                // do nothing
            } else {
                if ($this->window($i, $lines) > $this->window($i-1, $lines)) {
                    $increases++;
                }
            }
        }
        return $increases;
    }

    private function window(int $i, array $lines)
    {
        return $lines[$i] + $lines[$i-1] + $lines[$i-2];
    }
}