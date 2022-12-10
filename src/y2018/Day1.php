<?php

namespace Jtgrimes\Advent\y2018;

class Day1 extends \Jtgrimes\Advent\Day
{

    public $part1Solution = '522';
    public $part2Solution = '73364';
     public function part1()
    {
        $lines = $this->getInputAsCollectionOfLines();
        return $lines->map(function ($line) {
            return (int)trim($line);
        })->sum();
    }

    public function part2()
    {
        $lines = $this->getInputAsCollectionOfLines()->map(function ($line) {
            return (int)trim($line);
        });
        $visited = [];
        $position = 0;
        while (true) {
            foreach ($lines as $line) {
                $position += $line;
                if (array_key_exists($position, $visited)) {
                    return $position;
                }
                $visited[$position] = 1;
            }
        }
    }
}