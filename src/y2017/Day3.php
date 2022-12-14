<?php

namespace Jtgrimes\Advent\y2017;

use Jtgrimes\Advent\Support\Point;

class Day3 extends \Jtgrimes\Advent\Day
{

    private $input = '361527';

    public $part1Solution = '326';
    public $part2Solution = '363010';
    public function part1()
    {
        $point = new Point();
        $point->facing = 'E';
        $this->moveAlongSpiralTo($point, $this->input);
        return $point->manhattanDistanceTo(new Point());
    }

    public function part2()
    {
        $point = new Point();
        $point->facing = 'E';
        return $this->moveForPart2($point, $this->input);
    }

    private function moveAlongSpiralTo(Point $point, string $input)
    {
        $value = 1;
        $steps = 1;
        while ($value < (int)$input) {
            if ($value + $steps > (int)$input) {
                $steps = $input - $value;
            }
            $point->advance($steps);
            $value += $steps;
            $point->turnLeft();
            if ($point->facing == 'W' || $point->facing == 'E') {
                $steps++;
            }
        }
    }

    private function moveForPart2(Point $point, string $input)
    {
        $locations = [];
        $value = 1;
        $steps = 1;
        $stepsRemaining = 1;
        while ($value < (int)$input) {
            if ($value + $steps > (int)$input) {
                $steps = $input - $value;
            }
            $point->advance(1);
            $value ++;
            $stepsRemaining--;
            if ($stepsRemaining == 0) {
                $point->turnLeft();
                if ($point->facing == 'W' || $point->facing == 'E') {
                    $steps++;
                }
                $stepsRemaining = $steps;
            }
            $locations[$value] = ['x' => $point->x, 'y' => $point->y];
        }
        // now we've built a list of locaations, let's start figuring out values
        $sums[0][0] = 1;
        foreach ($locations as $i => $location) {
            $sum =
                $this->getSumForLocation($location['x']+1, $location['y'], $sums)
                + $this->getSumForLocation($location['x']+1, $location['y']+1, $sums)
                + $this->getSumForLocation($location['x'], $location['y']+1, $sums)
                + $this->getSumForLocation($location['x']-1, $location['y']+1, $sums)
                + $this->getSumForLocation($location['x']-1, $location['y'], $sums)
                + $this->getSumForLocation($location['x']-1, $location['y']-1, $sums)
                + $this->getSumForLocation($location['x'], $location['y']-1, $sums)
                + $this->getSumForLocation($location['x']+1, $location['y']-1, $sums);
            if ($sum > $input) {
                return $sum;
            }
            $sums[$location['x']][$location['y']] = $sum;
        }
    }

    private function getSumForLocation($x, $y, $sums)
    {
        if (array_key_exists($x, $sums) && array_key_exists($y, $sums[$x])) {
            return $sums[$x][$y];
        }
        return 0;
    }
}