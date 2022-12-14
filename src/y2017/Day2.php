<?php

namespace Jtgrimes\Advent\y2017;

use Illuminate\Support\Str;

class Day2 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = '36766';
    public $part2Solution = '261';

    public function part1()
    {
        return $this->getInputAsCollectionOfLines()
            ->map(function ($line) {
                $cleanedUp = preg_replace('/\s+/', ' ',$line);
                return explode(' ', $cleanedUp);
            })->reduce(function ($runningTotal, $line) {
                return $runningTotal + max($line) - min($line);
            });
    }

    public function part2()
    {
        return $this->getInputAsCollectionOfLines()
            ->map(function ($line) {
                $cleanedUp = preg_replace('/\s+/', ' ',$line);
                return explode(' ', $cleanedUp);
            })->reduce(function ($runningTotal, $line) {
                $lineCount = count($line);
                foreach ($line as $i => $item) {
                    foreach (range($i + 1, $lineCount -1) as $j) {
                        if ($item % $line[$j] == 0  || $line[$j] % $item == 0) {
                            return $runningTotal + ( $item > $line[$j]
                                    ? intdiv($item,  $line[$j])
                                    : intdiv($line[$j], $item));
                        }
                    }
                }
            });
    }
}