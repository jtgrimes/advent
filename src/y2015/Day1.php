<?php

namespace Jtgrimes\Advent\y2015;

use Jtgrimes\Advent\Day;

class Day1 extends Day
{
    public $part1Solution = '280';
    public $part2Solution = '1797';

    public function part1()
    {
        $characters = $this->getInputAsArrayOfCharacters();
        $floor = 0;
        foreach ($characters as $char) {
            $floor += ($char === '(' ? 1 : -1);
        }
        return $floor;
    }

    public function part2()
    {
        $characters = $this->getInputAsArrayOfCharacters();
        $floor = 0;
        foreach ($characters as $i => $char) {
            $floor += ($char === '(' ? 1 : -1);
            if ($floor < 0) {
                return $i + 1; // because the first char isn't the 0th
            }
        }
    }
}