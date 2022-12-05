<?php

namespace Jtgrimes\Advent\y2021;

class Day5 extends \Jtgrimes\Advent\Day
{

    public function part1()
    {
        $grid = $this->buildGrid();
        $cumulative = 0;
        foreach ($grid as $x) {
            foreach ($x as $value) {
                if ($value > 1) {
                    $cumulative++;
                }
            }
        }
        return $cumulative;
    }

    public function part2()
    {
        // 17557 is too low.
        $grid = $this->buildGrid(true);
        $cumulative = 0;
        foreach ($grid as $x) {
            foreach ($x as $value) {
                if ($value > 1) {
                    $cumulative++;
                }
            }
        }
        return $cumulative;
    }

    private function buildGrid($withDiagonals = false)
    {
        $lines = $this->getInputAsArrayOfLines();
        $grid = [];
        foreach ($lines as $line) {
            $parts = explode(' -> ', $line);
            $point1 = explode(',', $parts[0]);
            $point2 = explode(',', $parts[1]);
            if ($this->isVertical($point1, $point2)) {
                $grid = $this->plotVertical($grid, $point1, $point2);
            } elseif ($this->isHorizontal($point1, $point2)) {
                $grid = $this->plotHorizontal($grid, $point1, $point2);
            } elseif ($withDiagonals) {
                $grid = $this->plotDiagonal($grid, $point1, $point2);
            }
        }
        return $grid;

    }

    private function isHorizontal(array $point1, array $point2)
    {
        return (trim($point1[0]) == trim($point2[0]));
    }

    private function isVertical(array $point1, array $point2)
    {
        return (trim($point1[1]) == trim($point2[1]));
    }

    private function plotVertical(mixed $grid, array $point1, array $point2)
    {
        foreach (range($point1[0], $point2[0]) as $x) {
            $y = $point1[1];
            $grid = $this->plotPoint($grid, $x, $y);
        }
        return $grid;
    }

    private function plotHorizontal(mixed $grid, array $point1, array $point2)
    {
        foreach (range($point1[1], $point2[1]) as $y) {
            $x = $point1[0];
            $grid = $this->plotPoint($grid, $x, $y);
        }
        return $grid;
    }

    private function plotDiagonal(mixed $grid, array $point1, array $point2)
    {
        // you promised a line with a 1:1 slope...
        foreach (range($point1[1], $point2[1]) as $i => $y) {
            if ($point1[0] < $point2[0]) {
                $x = $point1[0] + $i;
            } else {
                $x = $point1[0] - $i;
            }
            $grid = $this->plotPoint($grid, $x, $y);
        }
        return $grid;

    }

    private function plotPoint($grid, $x, $y)
    {
        if (array_key_exists($x, $grid) && array_key_exists($y, $grid[$x])) {
            $grid[$x][$y] += 1;
        } else {
            $grid[$x][$y] = 1;
        }
        return $grid;
    }

}