<?php

namespace Jtgrimes\Advent\y2018;

use Illuminate\Support\Str;

class Day5 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = '11590';
    public $part2Solution = '4504';
    public function part1()
    {
        $polymer = $this->getInputAsArrayOfCharacters();
        $reduced = $this->reducePolymer($polymer);
        return count($reduced);
    }

    public function part2()
    {
        $results = [];
        foreach (range('a', 'z') as $unit) {
            $polymer = $this->getInputAsArrayOfCharacters();
            $polymer = $this->removeUnit($polymer, $unit);
            $results[$unit] = count($this->reducePolymer($polymer));
        }
        return min($results);
    }

    private function reducePolymer(array $polymer)
    {
        // 21512 is too high
        // 11592 is too high
        $i = 0;
        $match = ord('a') - ord('A'); // 32 characters between upper & lower case
        while ($i < count($polymer) - 1) {
            if (abs(ord($polymer[$i]) - ord($polymer[$i + 1])) == $match) {
                unset($polymer[$i + 1]);
                unset($polymer[$i]);
                // reindex
                $polymer = array_values($polymer);
                // and back up to see if the guys we removed made something new adjacent
                $i = $i == 0 ? 0 :  $i - 1;
            } else {
                $i++;
            }
        }
        return $polymer;
    }

    private function removeUnit(array $polymer, mixed $unit)
    {
        $asString = implode('', $polymer);
        return str_split(Str::replace([$unit, strtoupper($unit)], '', $asString));
    }
}