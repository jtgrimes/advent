<?php

namespace Jtgrimes\Advent\y2022;

use Jtgrimes\Advent\Support\PlankSnake;
use Jtgrimes\Advent\Support\Point;

class Day9 extends \Jtgrimes\Advent\Day
{
    public function part1()
    {
        $snake = new PlankSnake();
        $moves = $this->buildMoves();
        foreach ($moves as $move) {
            for ($i = 1; $i <= $move['distance']; $i ++) {
                $snake->move($move['direction']);
                $tailVisited[$snake->tailX()][$snake->tailY()] = 1;
            }
        }
        return $this->gridSum($tailVisited);
    }

    public function part2()
    {
        $snake = new PlankSnake(9);
        $moves = $this->buildMoves();
        foreach ($moves as $move) {
            for ($i = 1; $i <= $move['distance']; $i ++) {
                $snake->move($move['direction']);
                $tailVisited[$snake->tailX()][$snake->tailY()] = 1;
            }
        }
        return $this->gridSum($tailVisited);
    }

    private function buildMoves()
    {
        $lines = $this->getInputAsArrayOfLines();
        foreach ($lines as $line) {
            if (! empty(trim($line))) {
                list($direction, $distance) = explode(' ', trim($line));
                $moves[] = ['direction' => $direction, 'distance' => (int)$distance];
            }
        }
        return $moves;
    }

    private function gridSum(array $grid)
    {
        $cumulative = 0;
        foreach ($grid as $row) {
            $cumulative += array_sum($row);
        }
        return $cumulative;
    }

}