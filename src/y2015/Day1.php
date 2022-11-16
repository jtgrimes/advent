<?php

namespace Jtgrimes\Advent\y2015;

class Day1
{
    public function part1()
    {
        $inputDir = 'd:\code\jtgrimes\advent\input\\';
        $input = file_get_contents($inputDir.'2015/day1');
        $characters = str_split($input);
        $counter = 0;
        foreach ($characters as $char) {
            $counter += ($char === '(' ? 1 : -1);
        }
        return $counter;
    }

    public function part2()
    {
        $inputDir = 'd:\code\jtgrimes\advent\input\\';
        $input = file_get_contents($inputDir.'2015/day1');
        $characters = str_split($input);
        $counter = 0;
        foreach ($characters as $i => $char) {
            $counter += ($char === '(' ? 1 : -1);
            if ($counter < 0) {
                return $i + 1; // because the first char isn't the 0th
            }
        }
        return $counter;
    }
}