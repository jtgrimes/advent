<?php

namespace Jtgrimes\Advent\y2022;

use Illuminate\Support\Collection;

class Day18 extends \Jtgrimes\Advent\Day
{
    private $blocks;
    public $part1Solution = '3364';

    public function part1()
    {
        $this->blocks = $this->getBlocks();
        return $this->countExposedFaces();
    }

    public function part2()
    {
        // TODO: Implement part2() method.
    }

    private function getBlocks()
    {
        return $this->getInputAsCollectionOfLines()->map(function ($line) {
            list($x, $y, $z) = explode(',', trim($line));
            return (object)['x' => (int)$x, 'y' => (int)$y, 'z' => (int)$z];
        });
    }
    private function countExposedFaces()
    {
        return $this->blocks->reduce(function ($visible, $block, $i) {
            $seeTop = (int)$this->blocks->where('x', $block->x)
                ->where('y', $block->y)
                ->where('z', $block->z + 1)
                ->isEmpty();
            $seeBottom = (int)$this->blocks->where('x', $block->x)
                ->where('y', $block->y)
                ->where('z', $block->z - 1)
                ->isEmpty();
            $seeNorth = (int)$this->blocks->where('x', $block->x)
                ->where('y', $block->y + 1)
                ->where('z', $block->z)
                ->isEmpty();
            $seeSouth = (int)$this->blocks->where('x', $block->x)
                ->where('y', $block->y - 1)
                ->where('z', $block->z)
                ->isEmpty();
            $seeEast = (int)$this->blocks->where('x', $block->x+1)
                ->where('y', $block->y)
                ->where('z', $block->z)
                ->isEmpty();
            $seeWest = (int)$this->blocks->where('x', $block->x-1)
                ->where('y', $block->y)
                ->where('z', $block->z)
                ->isEmpty();
            echo ("Block $i: $seeTop, $seeBottom,  $seeNorth,  $seeSouth,  $seeWest,  $seeEast\n");
            return $visible + $seeTop + $seeBottom + $seeNorth + $seeSouth + $seeWest + $seeEast;
        });
    }
    
}