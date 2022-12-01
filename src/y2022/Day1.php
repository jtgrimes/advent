<?php

namespace Jtgrimes\Advent\y2022;

class Day1 extends \Jtgrimes\Advent\Day
{

    public function part1()
    {
        $elves = $this->parseInputData();
        return $elves->max();
    }

    public function part2()
    {
        $elves = $this->parseInputData();
        return $elves->sortDesc()->take(3)->sum();
    }

    private function parseInputData()
    {
        $lines = $this->getInputAsArrayOfLines();
        $elves = collect([]);
        $cumulative = 0;
        foreach ($lines as $line) {
            if ((int)$line == 0) {
                $elves->add($cumulative);
                $cumulative = 0;
            } else {
                $cumulative += (int)$line;
            }
        }
        return $elves;
    }
}