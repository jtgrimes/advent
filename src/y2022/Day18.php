<?php

namespace Jtgrimes\Advent\y2022;

use Illuminate\Support\Collection;

class Day18 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = '3364';

    public function part1()
    {
        $blocks = $this->getBlocks();
        return $this->countExposedFaces($blocks);
    }

    public function part2()
    {
        // TODO: Implement part2() method.
    }

    private function getBlocks()
    {
        $blocks = [];
        $this->getInputAsCollectionOfLines()->each(function ($line) use (&$blocks){
            list($x, $y, $z) = explode(',', trim($line));
            $blocks[(int)$x][(int)$y][(int)$z] = 'X';
        });
        return $blocks;
    }
    private function countExposedFaces($blocks)
    {
        $count = 0;
        foreach ($blocks as $i => $x) {
            foreach ($x as $j => $y) {
                foreach ($y as $k => $z) {
                    $seeTop = (int)!isset($blocks[$i][$j][$k+1]);
                    $seeBottom = (int)!isset($blocks[$i][$j][$k-1]);
                    $seeNorth = (int)!isset($blocks[$i][$j+1][$k]);
                    $seeSouth = (int)!isset($blocks[$i][$j-1][$k]);
                    $seeEast = (int)!isset($blocks[$i+1][$j][$k]);
                    $seeWest = (int)!isset($blocks[$i-1][$j][$k]);
                    echo ("Block $i,$j,$k: $seeTop, $seeBottom,  $seeNorth,  $seeSouth,  $seeWest,  $seeEast\n");
                    $count += $seeTop + $seeBottom + $seeNorth + $seeSouth + $seeWest + $seeEast;
                }
            }
        }
        return $count;
    }

}