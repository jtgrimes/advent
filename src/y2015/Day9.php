<?php

namespace Jtgrimes\Advent\y2015;

use Jtgrimes\Advent\Day;
use Jtgrimes\Advent\y2015\Support\Combinator;

class Day9 extends Day
{
    public function part1()
    {
        $distances = $this->calculateDistances();
        return collect($distances)->min();
    }

    public function part2()
    {
        $distances = $this->calculateDistances();
        return collect($distances)->max();
    }

    private function calculateDistances()
    {
        $legs = [];
        $cities = [];
        $lines = $this->getInputAsArrayOfLines();
        foreach ($lines as $line) {
            $parts = explode(' ', $line);
            // format is CITY to CITY = NUM, so we want parts 0,2,4
            $legs[$parts[0]][$parts[2]] = (int)$parts[4];
            $legs[$parts[2]][$parts[0]] = (int)$parts[4];

            if (! in_array($parts[0], $cities)) {
                $cities[] = $parts[0];
            }
            if (! in_array($parts[2], $cities)) {
                $cities[] = $parts[2];
            }
        }
        print_r($cities);
        $possibleRoutes = (new Combinator($cities))->permutations();
        $distances = [];
        foreach ($possibleRoutes as $route) {
            $distance = 0;
            foreach ($route as $i => $city) {
                if ($i == 0) {
                    // at first stop, no incoming leg
                } else {
                    $distance += $legs[$route[$i - 1]][$city];
                }
            }
            $distances[] = $distance;
        }
        return $distances;
    }

}
