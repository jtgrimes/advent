<?php

namespace Jtgrimes\Advent\y2022;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Jtgrimes\Advent\Support\Point;

class Day22 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = '77318';
    public function part1()
    {
        $this->addMacrosToBoard();
        $board = $this->getBoard();
        $route = $this->getRoute();
        $point = new Point(1, $board->firstOpenForRow(1));
        $point->facing = 'E';
        $point->topOrigin = true;
        $point = $this->walkBoard($board, $route, $point);
        return $this->pointToPassword($point);
    }

    public function part2()
    {
    }

    private function pointToPassword($point)
    {
        return 1000 * ($point->x) + 4 * ($point->y) + match($point->facing) {
            'E' => 0,
            'S' => 1,
            'W' => 2,
            'N' => 3,
        };
    }

    private function getBoard()
    {
        $board = [];
        $lines = $this->getInputAsArrayOfLines();
        foreach ($lines as $i=>$line) {
            $line = ' '.Str::remove(PHP_EOL, $line);
            $board[$i + 1] = collect(str_split($line));
        }
        return collect($board);
    }

    private function addMacrosToBoard() {
        Collection::macro('firstOpenForRow', function ($row) {
            return $this->get($row)->filter(function ($character) {
                return $character == '.';
            })->keys()->first();
        });
        Collection::macro('advance', function (Point $point, $wrapFunction) {
            echo "Start at {$point->x}, {$point->y} facing {$point->facing}";
            $clone = $point->clone();
            $clone->advance(1);
            $nextPosition = optional($this->get($clone->x))->get($clone->y) ?? ' ';
            switch ($nextPosition) {
                case '.':
                    return $clone;
                case '#':
                    // don't move, there's a wall in front of us
                    return $point;
                case ' ':
                    $clone = $this->$wrapFunction($point);
                    if ($this->get($clone->x)->get($clone->y) == '#') {
                        // wall, we're stuck
                        echo ("--> {$point->x}, {$point->y}\n");
                        return $point;
                    }
                    echo ("--> {$clone->x}, {$clone->y}\n");
                    return $clone;
                default:
                    throw new Exception("Unexpected board contents: $nextPosition");
            }
        });
       Collection::macro('advanceAndWrap', function  (Point $point) {
           $columnY = $this->mapWithKeys(function ($row, $i) use ($point){
               return [$i => $row->get($point->y)];
           });
            switch ($point->facing) {
                case 'N':
                    $nextXPosition = $columnY->reject(function ($char) {return is_null($char) || $char == ' ';})->keys()->last();
                    $nextYPosition = $point->y;
                    break;
                case 'S':
                    $nextXPosition = $columnY->reject(function ($char) {return is_null($char) || $char == ' ';})->keys()->first();
                    $nextYPosition = $point->y;
                    break;
                case 'W':
                    $nextXPosition = $point->x;
                    $nextYPosition = $this->get($point->x)->reject(function ($char) {return is_null($char) || $char == ' ';})->keys()->last();
                    break;
                case 'E':
                    $nextXPosition = $point->x;
                    $nextYPosition = $this->get($point->x)->reject(function ($char) {return is_null($char) || $char == ' ';})->keys()->first();
                    break;
                default:
                    throw new \Exception("Unexpected facing: {$point->facing}");
            }

            if (! $this->get($nextXPosition)) {
                throw new Exception("Could not advance from {$point->x}, {$point->y} to $nextXPosition, $nextYPosition because X invalid");
            }
           if (! $this->get($nextXPosition)->get($nextYPosition)) {
               throw new Exception("Could not advance from {$point->x}, {$point->y} to $nextXPosition, $nextYPosition because Y invalid");
           }
            if ($this->get($nextXPosition)->get($nextYPosition) == '#') {
                return $point;
            }
            $point->x = $nextXPosition;
            $point->y = $nextYPosition;
            return $point;
        });
        Collection::macro('advanceAndWrapPart2', function  (Point $point) {
            return $point;
        });
    }

    private function getRoute()
    {
        $input = trim(file_get_contents($this->inputFileName().'route'));
        return collect(preg_split('/([RL])/', $input, -1, PREG_SPLIT_DELIM_CAPTURE));

    }

    private function walkBoard(Collection $board, Collection $route, Point $point, $advanceFunction = 'advanceAndWrap')
    {
        $moves = $route->each(function ($instruction) use ($board, &$point, $advanceFunction) {
            if (is_numeric($instruction)) {
                for ($i = 0; $i < $instruction;$i++) {
                    $point = $board->advance($point, $advanceFunction);
                    echo " land at point {$point->x}, {$point->y}\n";
                }
            } else {
                $point->turn($instruction);
            }
        });
        return $point;
    }



}