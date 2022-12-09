<?php

namespace Jtgrimes\Advent\Support;

class Point
{
    public function __construct(public $x = 0, public $y = 0){}

    public function move($direction, $distance)
    {
        switch (strtoupper($direction)) {
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
                throw new \Exception("Unexpected direction: $direction");
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

}