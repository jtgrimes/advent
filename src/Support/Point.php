<?php

namespace Jtgrimes\Advent\Support;

class Point
{
    public $facing = 'N';

    public function __construct(public $x = 0, public $y = 0){}

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
                $this->x += $distance;
                break;
            case 'S':
            case 'D':
                $this->x -= $distance;
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