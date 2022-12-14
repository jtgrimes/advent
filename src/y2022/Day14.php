<?php

namespace Jtgrimes\Advent\y2022;

class Day14 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = '1330';
    public function part1()
    {
        $map = $this->buildMap();
        $turns = 0;
        $depth = $this->findMaxDepth($map);
        while ($this->addSand($map, $depth)) {
            $turns++;
        }
        return $turns;
    }

    public function part2()
    {
        // using the same technique as part 1, we run out of memory.... needs more thinks
    }

    private function buildMap()
    {
        $grid = [];
        $paths = $this->getInputAsArrayOfLines();
        foreach ($paths as $path) {
            $points = explode(' -> ', trim($path));
            foreach ($points as $i => $point) {
                if (array_key_exists($i + 1, $points)) { // if there is a point after this one
                    list($x, $y) = explode(',', $point);
                    list($nextX, $nextY) = explode(',', $points[$i+1]);
                    if ($x == $nextX) {
                        // fill horizontally
                        foreach(range($y, $nextY) as $newY) {
                            $grid[$x][$newY] = 'R';
                        }
                    } else {
                        foreach(range($x, $nextX) as $newX) {
                            $grid[$newX][$y] = 'R';
                        }
                    }

                }
            }
        }
        return $grid;
    }

    private function findMaxDepth(array $map)
    {
        $max = 0;
        foreach ($map as $row) {
            if (max(array_keys($row)) > $max) {
                $max = max(array_keys($row));
            }
        }
        return $max;
    }

    private function addSand(&$map, $depth, )
    {
        $sandPositionX = 500;
        $sandPositionY = 0;
        $atRest = false;
        while (! $atRest) {
            list($nextPositionX, $nextPositionY) = $this->nextSandPosition($map, [$sandPositionX, $sandPositionY]);
//            echo ("From $sandPositionX, $sandPositionY to $nextPositionX, $nextPositionY\n");
//            echo ("At height $nextPositionY, depth $depth\n");
            if ($nextPositionY == $sandPositionY) {
                $atRest = true;
                $map[$sandPositionX][$sandPositionY] = 's';
            }
            if ($nextPositionY > $sandPositionY && $nextPositionY < $depth) {
                $sandPositionX = $nextPositionX;
                $sandPositionY = $nextPositionY;
            }
            if ($nextPositionY == $depth) {
                return false;
            }
        }
        return true;

    }

    private function nextSandPosition(array $map, array $position)
    {
        list($positionX, $positionY) = $position;
        // try to fall down
        if(! array_key_exists($positionX, $map) || ! array_key_exists($positionY+1, $map[$positionX])) {
            // there's nothing directly down, fall down
            return [$positionX, $positionY + 1];
        }

        if(!array_key_exists($positionX-1, $map) || !array_key_exists($positionY+1, $map[$positionX -1])) {
            // fall down-left
            return [$positionX -1, $positionY + 1];
        }
        if(!array_key_exists($positionX+1, $map) || !array_key_exists($positionY+1, $map[$positionX+1])) {
            // fall down-left
            return [$positionX + 1, $positionY + 1];
        }
        // nowhere to fall - next position = this position;
        return $position;
    }

    private function addFloor(array &$map, int $at)
    {
        foreach ($map as $key => $column) {
            $map[$key][$at] = 'R';
        }
    }
}