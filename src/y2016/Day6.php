<?php

namespace Jtgrimes\Advent\y2016;

class Day6 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = 'kqsdmzft';
    public $part2Solution = 'tpooccyo';
    public function part1()
    {
        $frequency = array_fill_keys(range('a','z'), 0);
        $position = array_fill_keys(range(0,7), $frequency);
        $lines = $this->getInputAsCollectionOfLines()->each(function($line) use (&$position) {
            $letters = str_split($line);
            foreach ($letters as $p => $letter) {
                $position[$p][$letter] += 1;
            }
        });
        $code = '';
        foreach ($position as $p) {
            $code .= array_keys($p, max($p))[0];
        }
        return $code;
    }

    public function part2()
    {
        $frequency = array_fill_keys(range('a','z'), 0);
        $position = array_fill_keys(range(0,7), $frequency);
        $lines = $this->getInputAsCollectionOfLines()->each(function($line) use (&$position) {
            $letters = str_split($line);
            foreach ($letters as $p => $letter) {
                $position[$p][$letter] += 1;
            }
        });
        $code = '';
        foreach ($position as $p) {
            $code .= array_keys($p, min($p))[0];
        }
        return $code;
    }
}