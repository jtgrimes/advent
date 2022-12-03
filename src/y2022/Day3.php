<?php

namespace Jtgrimes\Advent\y2022;

class Day3 extends \Jtgrimes\Advent\Day
{

    public function part1()
    {
        $rucks = $this->getInputAsCollectionOfLines();
        return $rucks->map(function ($ruck) {
            $items = str_split(trim($ruck));
            $secondHalf = array_splice($items, count($items) / 2, count($items), []);
            // items now only contains the first half ... rename because I'll confuse myself otherwise
            $firstHalf = $items;
            $duplicates = array_intersect($firstHalf, $secondHalf);
            $duplicate = array_values($duplicates)[0];
            echo ("$duplicate: ".$this->toScore($duplicate)."\n");
            return $this->toScore($duplicate);
        })->sum();
    }

    public function part2()
    {
        $rucks = $this->getInputAsCollectionOfLines();
        return $rucks->chunk(3)->map(function ($group){
            $first = str_split(trim($group->shift()));
            $second = str_split(trim($group->shift()));
            $third = str_split(trim($group->shift()));
            $duplicates = array_intersect($first, $second, $third);
            $duplicate = array_values($duplicates)[0];
            echo ("$duplicate: ".$this->toScore($duplicate)."\n");
            return $this->toScore($duplicate);
        })->sum();
    }

    private function toScore($char)
    {
        if (ord($char) < 91) {
            // upper case
            return ord($char) - 38; // sets A to 27
        }
        return ord($char) - 96;
    }
}