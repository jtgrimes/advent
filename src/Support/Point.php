<?php

namespace Jtgrimes\Advent\Support;

class Point
{
    public $facing = 'N';
    public $topOrigin = false; // set to true if the origin is the upper left instead of lower left/center

    public function __construct(public $x = 0, public $y = 0){}

    public function clone()
    {
        $clone = new self($this->x, $this->y);
        $clone->facing = $this->facing;
        $clone->topOrigin = $this->topOrigin;
        return $clone;
    }

    public function move($direction, $distance)
    {
        $this->facing = $direction;
        $this->advance($distance);
    }

    public function advance($distance)
    {
        switch (strtoupper($this->facing)) {
            case 'N':
            case 'U':
                $this->x += ($this->topOrigin ? -1: 1) * $distance;
                break;
            case 'S':
            case 'D':
            $this->x += ($this->topOrigin ? 1: -1) * $distance;
                break;
            case 'W':
            case 'L':
                $this->y -= $distance;
                break;
            case 'E':
            case 'R':
                $this->y += $distance;
                break;
            default:
                throw new \Exception("Unexpected direction: {$this->facing}");
        }
    }

    public function equals(Point $b)
    {
        return ($this->x == $b->x && $this->y == $b->y);
    }

    public function isAdjacentTo(Point $b)
    {
        return ($this->x >= $b->x -1  && $this->x <= $b->x + 1 && $this->y >= $b->y-1 && $this->y <= $b->y+1);
    }

    public function manhattanDistanceTo(Point $b)
    {
        return abs($this->x - $b->x) + abs($this->y - $b->y);
    }

    public function turn($direction)
    {
        switch ($direction) {
            case 'R':
            case 'r':
                return $this->turnRight();
            case 'L':
            case 'l':
                return $this->turnLeft();
            default:
                throw new \Exception("Unexpected turn direction: $direction");
        }
    }

    public function turnLeft()
    {
        $this->facing = match($this->facing) {
            'N' => 'W',
            'W' => 'S',
            'S' => 'E',
            'E' => 'N',
        };
    }

    public function turnRight()
    {
        $this->facing = match($this->facing) {
            'N' => 'E',
            'W' => 'N',
            'S' => 'W',
            'E' => 'S',
        };
    }

}