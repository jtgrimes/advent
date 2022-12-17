<?php

namespace Jtgrimes\Advent\y2019;

class Day1 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = '3317970';
    public $part2Solution = '4974073';

    public function part1()
    {
        return $this->getInputAsCollectionOfLines()
            ->reduce(function ($running, $module) {
            return $running + $this->calculateFuel((int)$module);
        });
    }

    public function part2()
    {
        return $this->getInputAsCollectionOfLines()
            ->reduce(function ($running, $module) {
            return $running + $this->cumulativeFuel((int)$module);
        });
    }

    private function cumulativeFuel($fuel)
    {
        $cumulative = 0;
//        $cumulative = $fuel;
        while ($fuel > 0) {
            echo ("Fuel $fuel, Cumulative $cumulative\n");
            $fuel = $this->calculateFuel($fuel);
            $cumulative += $fuel;
        }
        return $cumulative;
    }

    private function calculateFuel(int $amount)
    {
        if (intdiv($amount, 3) - 2 > 0) {
            return intdiv($amount, 3) - 2;
        }
        return 0;
    }
}