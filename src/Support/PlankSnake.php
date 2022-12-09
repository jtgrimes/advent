<?php

namespace Jtgrimes\Advent\Support;

class PlankSnake
{
    private Point $head;
    private Point $tail;

    public function __construct()
    {
        $this->head = new Point();
        $this->tail = new Point();
    }

    public function tailX()
    {
        return $this->tail->x;
    }

    public function tailY()
    {
        return $this->tail->y;
    }

    public function dump()
    {
        echo("HEAD: {$this->head->x}, {$this->head->y}    TAIL: {$this->tail->x}, {$this->tail->y}\n");
    }
    public function move($direction)
    {
        $this->head->move($direction, 1);
        if ($this->head->equals($this->tail) || $this->head->isAdjacentTo($this->tail)) {
            // we don't need to move the butt
            return;
        }
        if ($this->head->x == $this->tail->x) {
            $this->tail->y = $this->tail->y + ($this->head->y > $this->tail->y ? 1 : -1);
            return;
        }
        if ($this->head->y == $this->tail->y) {
            $this->tail->x = $this->tail->x + ($this->head->x > $this->tail->x ? 1 : -1);
            return;
        }
        // not moving horizontally or vertically - guess it's diagonal
        $this->tail->x = $this->tail->x + ($this->head->x > $this->tail->x ? 1 : -1);
        $this->tail->y = $this->tail->y + ($this->head->y > $this->tail->y ? 1 : -1);
    }
}