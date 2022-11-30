<?php

namespace Jtgrimes\Advent\y2016;

use Jtgrimes\Advent\Day;

class Day1 extends Day
{
    protected $position_x = 0;
    protected $position_y = 0;
    protected $facing = 'N';
    protected $visited = [];

    public function part1()
    {
        $input = $this->getInputAsString();
        $directions = $this->parseDirections($input);
        foreach ($directions as $direction) {
            $this->turn($direction[0]);
            $this->advance($direction[1]);
        }
        return $this->getDistance();
    }

    public function part2()
    {
        $input = $this->getInputAsString();
        $directions = $this->parseDirections($input);
        foreach ($directions as $direction) {
            $this->turn($direction[0]);
            foreach (range(1,$direction[1]) as $block) {
                $this->advance(1);
                if ($this->firstVisit()) {
                    $this->markPositionVisited();
                } else {
                    return $this->getDistance();
                }
            }
        }
    }

    private function parseDirections(string $input)
    {
        $directions = [];
        $steps = explode(', ', $input);
        foreach ($steps as $step) {
            $direction = substr($step, 0, 1);
            $distance = (int)substr($step, 1);
            $directions[] = [$direction, $distance];
        }
        return $directions;
    }

    private function turn(string $direction)
    {
        switch ($this->facing) {
            case 'N':
                $this->facing = ($direction === 'R' ? 'E' : 'W');
                break;
            case 'S':
                $this->facing = ($direction === 'R' ? 'W' : 'E');
                break;
            case 'W':
                $this->facing = ($direction === 'R' ? 'N' : 'S');
                break;
            case 'E':
                $this->facing = ($direction === 'R' ? 'S' : 'N');
                break;
        }

    }

    private function advance(int $blocks)
    {
        switch ($this->facing) {
            case 'N':
                $this->position_x += $blocks;
                break;
            case 'S':
                $this->position_x -= $blocks;
                break;
            case 'W':
                $this->position_y -= $blocks;
                break;
            case 'E':
                $this->position_y += $blocks;
                break;
        }
    }

    private function getDistance()
    {
        return abs($this->position_x) + abs($this->position_y);
    }

    private function firstVisit()
    {
        return ! array_key_exists("x$this->position_x,y$this->position_y", $this->visited);
    }

    private function markPositionVisited()
    {
        $this->visited["x$this->position_x,y$this->position_y"] = true;
    }


}