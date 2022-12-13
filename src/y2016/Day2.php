<?php

namespace Jtgrimes\Advent\y2016;

use Jtgrimes\Advent\Day;

class Day2 extends Day
{
    public $part1Solution = '69642';
    public $part2Solution = '8CB23';

    public function part1()
    {
        return $this->moveAround(function ($position, $direction) {
            switch ($direction) {
                case 'U':
                    if (! in_array($position, [1, 2, 3])) {
                        return $position - 3;
                    }
                    return $position;
                case 'D':
                    if (! in_array($position, [7, 8, 9])) {
                        return $position + 3;
                    }
                    return $position;
                case 'L':
                    if (! in_array($position, [1, 4, 7])) {
                        return $position - 1;
                    }
                    return $position;
                case 'R':
                    if (! in_array($position, [3, 6, 9])) {
                        return $position + 1;
                    }
                    return $position;
            }
        });
    }

    public function part2()
    {
        return $this->moveAround(function ($position, $direction) {
            switch ($position) {
                case '1':
                    return match($direction) {
                        'D' => '3',
                        default => $position,
                    };
                case '2':
                    return match($direction) {
                        'R' => '3',
                        'D' => '6',
                        default => $position,
                    };
                case '3':
                    return match($direction) {
                        'U' => '1',
                        'D' => '7',
                        'L' => '2',
                        'R' => '4',
                        default => $position,
                    };
                case '4':
                    return match($direction) {
                        'D' => '8',
                        'L' => '3',
                        default => $position,
                    };
                case '5':
                    return match($direction) {
                        'R' => '6',
                        default => $position,
                    };
                case '6':
                    return match($direction) {
                        'U' => '2',
                        'D' => 'A',
                        'L' => '5',
                        'R' => '7',
                        default => $position,
                    };
                case '7':
                    return match($direction) {
                        'U' => '3',
                        'D' => 'B',
                        'L' => '6',
                        'R' => '8',
                        default => $position,
                    };
                case '8':
                    return match($direction) {
                        'U' => '4',
                        'D' => 'C',
                        'L' => '7',
                        'R' => '9',
                        default => $position,
                    };
                case '9':
                    return match($direction) {
                        'L' => '8',
                        default => $position,
                    };
                case 'A':
                    return match($direction) {
                        'U' => '6',
                        'R' => 'B',
                        default => $position,
                    };
                case 'B':
                    return match($direction) {
                        'U' => '7',
                        'D' => 'D',
                        'L' => 'A',
                        'R' => 'C',
                        default => $position,
                    };
                case 'C':
                    return match($direction) {
                        'U' => '8',
                        'L' => 'B',
                        default => $position,
                    };
                case 'D':
                    return match($direction) {
                        'U' => 'B',
                        default => $position,
                    };
            }
       });
    }

    public function moveAround($moveFunction)
    {
        $code = '';
        $presses = $this->getInputAsCollectionOfLines();
        $presses->each(function ($directions) use (&$code, $moveFunction) {
            $moves = collect(str_split($directions));
            $start = empty($code) ? 5 : collect(str_split($code))->last();
            $press = $moves->reduce($moveFunction, $start);
            $code .= $press;
        });
        return $code;
    }
}