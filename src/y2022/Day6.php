<?php

namespace Jtgrimes\Advent\y2022;

use Illuminate\Support\Str;
use Jtgrimes\Advent\Day;

class Day6 extends Day
{

    public $part1Solution = '1816';
    public $part2Solution = '2625';
    public function part1()
    {
        $input = $this->getInputAsString();
        for ($i = 3; $i < strlen($input); $i++) {
            if ($this->noDuplicateCharacters(substr($input, $i-3, 4))) {
                return $i + 1; // Elves use 1-indexed arrays, not 0 indexed
            }
        }
    }

    public function part2()
    {
        $input = $this->getInputAsString();
        for ($i = 13; $i < strlen($input); $i++) {
            if ($this->noDuplicateCharacters(substr($input, $i-13, 14))) {
                return $i + 1; // Elves use 1-indexed arrays, not 0 indexed
            }
        }
    }

    private function noDuplicateCharacters(string $str)
    {
        $characters = collect(str_split($str));
        return $characters->duplicates()->isEmpty();
    }
}