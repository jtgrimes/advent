<?php

namespace Jtgrimes\Advent\y2022;

class Day8 extends \Jtgrimes\Advent\Day
{
    private $forest;
    public function part1()
    {
        $visible = 0;
        $this->forest = $this->getInputAsCharacterGrid();
        foreach ($this->forest as $i => $row) {
            foreach ($row as $j => $tree) {
                if ($this->isVisible($i, $j)) {
                    $visible ++;
                }
            }
        }
        return $visible;
    }

    public function part2()
    {
        $this->forest = $this->getInputAsCharacterGrid();
        foreach ($this->forest as $i => $row) {
            foreach ($row as $j => $tree) {
                $score[$i][$j] = $this->calculateScore($i, $j);
            }
        }
        $maxScore = 0;
        foreach ($score as $row) {
            if (max($row) > $maxScore) {
                $maxScore = max($row);
            }
        }
        return $maxScore;
    }

    private function isVisible(int $row, int $col)
    {
        // check the edges
        if ($row == 0 || $col == 0 || $row == count($this->forest)-1 || $col == count($this->forest[0])-1) {
            return true;
        }
        return ($this->isVisibleFromNorth($row, $col)
            || $this->isVisibleFromSouth($row, $col)
            || $this->isVisibleFromEast($row, $col)
            || $this->isVisibleFromWest($row, $col));
    }

    private function isVisibleFromNorth(int $row, int $col)
    {
        $currentHeight = 0;
        foreach (range(0, $row-1) as $r) {
            if ($this->forest[$r][$col] >= $currentHeight) {
                $currentHeight = $this->forest[$r][$col];
            }
        }
        if ($this->forest[$row][$col] > $currentHeight) {
            return true;
        }
        return false;
    }

    private function isVisibleFromSouth(int $row, int $col)
    {
        $currentHeight = 0;
        foreach (range(count($this->forest)-1, $row+1) as $r) {
            if ($this->forest[$r][$col] >= $currentHeight) {
                $currentHeight = $this->forest[$r][$col];
            }
        }
        if ($this->forest[$row][$col] > $currentHeight) {
            return true;
        }
        return false;
    }

    private function isVisibleFromWest(int $row, int $col)
    {
        $currentHeight = 0;
        foreach (range(0, $col - 1) as $c) {
            if ($this->forest[$row][$c] >= $currentHeight) {
                $currentHeight = $this->forest[$row][$c];
            }
        }
        if ($this->forest[$row][$col] > $currentHeight) {
            return true;
        }
        return false;
    }

    private function isVisibleFromEast(int $row, int $col)
    {
        $currentHeight = 0;
        foreach (range(count($this->forest[0])-1, $col + 1) as $c) {
            if ($this->forest[$row][$c] >= $currentHeight) {
                $currentHeight = $this->forest[$row][$c];
            }
        }
        if ($this->forest[$row][$col] > $currentHeight) {
            return true;
        }
        return false;
    }

    private function calculateScore(int $row, int $col)
    {
        return $this->northScore($row, $col)
            * $this->southScore($row, $col)
            * $this->eastScore($row, $col)
            * $this->westScore($row, $col);
    }

    private function northScore(int $row, int $col)
    {
        if ($row == 0) {
            return 0;
        }
        $visible = 0;
        $base = $this->forest[$row][$col];
        foreach (range($row - 1, 0) as $r) {
            if ($this->forest[$r][$col] < $base) {
                $visible++;
            } else {
                return $visible + 1;
            }
        }
        return $visible;
    }

    private function southScore(int $row, int $col)
    {
        if ($row == count($this->forest)-1) {
            return 0;
        }
        $visible = 0;
        $base = $this->forest[$row][$col];
        foreach (range($row + 1, count($this->forest)-1) as $r) {
            if ($this->forest[$r][$col] < $base) {
                $visible++;
            } else {
                return $visible + 1;
            }
        }
        return $visible;
    }

    private function westScore(int $row, int $col)
    {
        if ($col == 0) {
            return 0;
        }
        $visible = 0;
        $base = $this->forest[$row][$col];
        foreach (range($col - 1, 0) as $c) {
            if ($this->forest[$row][$c] < $base) {
                $visible++;
            } else {
                return $visible + 1;
            }
        }
        return $visible;
    }

    private function eastScore(int $row, int $col)
    {
        if ($col == count($this->forest[0])-1) {
            return 0;
        }
        $visible = 0;
        $base = $this->forest[$row][$col];
        foreach (range($col + 1, count($this->forest[0])-1) as $c) {
            if ($this->forest[$row][$c] < $base) {
                $visible++;
            } else {
                return $visible + 1;
            }
        }
        return $visible;
    }
}