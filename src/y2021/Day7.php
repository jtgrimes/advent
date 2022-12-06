<?php

namespace Jtgrimes\Advent\y2021;

class Day7 extends \Jtgrimes\Advent\Day
{

    private $cachedSums = [];

    public function part1()
    {
        $fuelFunction = function ($cumulativeFuel, $crab, $position) {
            return $cumulativeFuel + abs($crab - $position);
        };
        $worstCase = function ($crabs) {
            return $crabs->count() * $crabs->max();
        };
        return $this->calculateMinimumDistance($fuelFunction, $worstCase);
    }

    public function part2()
    {
        $fuelFunction = function ($cumulativeFuel, $crab, $position) {
            return $cumulativeFuel + $this->cumulativeSum(abs($crab - $position));
        };
        $worstCase = function ($crabs) {
            return $crabs->count() * $this->cumulativeSum($crabs->max());
        };
        return $this->calculateMinimumDistance($fuelFunction, $worstCase);
    }

    private function calculateMinimumDistance(callable $fuelFunction, callable $worstCase)
    {
        $crabs = collect(explode(',', trim($this->getInputAsString())));
        $maximumCrab = $crabs->max();
        // can't do any worse than this:
        $minDistance = $worstCase($crabs);
        foreach (range(0, $maximumCrab) as $position) {
            $distance = $crabs->reduce(function ($cumulativeFuel, $crab) use ($fuelFunction, $position) {
                return $fuelFunction($cumulativeFuel, $crab, $position);
            });
            if ($distance < $minDistance) {
                $minDistance = $distance;
            }
        }
        return $minDistance;
    }

    private function cumulativeSum(int $num)
    {
        if ( ! array_key_exists($num, $this->cachedSums)) {
            // I feel like there should already be a function for this, but can't think what it is
            $sum = 0;
            foreach (range(1, $num) as $i) {
                $sum += $i;
            }
            $this->cachedSums[$num] = $sum;
        }
        return $this->cachedSums[$num];
    }
}