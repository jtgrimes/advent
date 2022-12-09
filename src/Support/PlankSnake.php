<?php

namespace Jtgrimes\Advent\Support;

class PlankSnake
{
    private $segments = [];

    public function __construct(private $length = 1)
    {
        foreach (range(0,$length) as $position)
        $this->segments[$position] = new Point();
    }

    public function tailX()
    {
        return $this->segments[$this->length]->x;
    }

    public function tailY()
    {
        return $this->segments[$this->length]->y;
    }

    public function move($direction)
    {
        foreach ($this->segments as $i => $segment) {
            if ($i == 0) {
                // this is the head - just move it
                $this->segments[0]->move($direction, 1);
            } else {
                $prior = $this->segments[$i - 1];
                if ($prior->equals($segment) || $prior->isAdjacentTo($segment)) {
                    // we don't need to move anything else
                    return;
                }
                if ($prior->x == $segment->x) {
                    $segment->move($prior->y > $segment->y ? "R" : 'L', 1);
                    continue;
                }
                if ($prior->y == $segment->y) {
                    $segment->move($prior->x > $segment->x ? "U" : 'D', 1);
                    continue;
                }
                // not moving horizontally or vertically - guess it's diagonal
                $segment->move($prior->x > $segment->x ? "U" : 'D', 1);
                $segment->move($prior->y > $segment->y ? "R" : 'L', 1);
            }
        }
    }
}