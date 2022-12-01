<?php

namespace Jtgrimes\Advent\y2021;

class Day2 extends \Jtgrimes\Advent\Day
{

    public function part1()
    {
        $position = 0;
        $depth = 0;
        $lines = $this->getInputAsArrayOfLines();
        foreach ($lines as $line) {
            $parts = explode(' ', $line);
            $direction = $parts[0];
            $amount = (int)trim($parts[1]);
            switch ($direction) {
                case 'forward':
                    $position += $amount;
                    break;
                case 'up':
                    $depth -= $amount;
                    break;
                case 'down':
                    $depth += $amount;
                    break;
                default:
                    throw new \Exception("Unexpected direction: $direction");
            }
        }
        return $depth * $position;
    }

    public function part2()
    {
        $position = 0;
        $depth = 0;
        $aim = 0;
        $lines = $this->getInputAsArrayOfLines();
        foreach ($lines as $line) {
            $parts = explode(' ', $line);
            $direction = $parts[0];
            $amount = (int)trim($parts[1]);
            switch ($direction) {
                case 'forward':
                    $position += $amount;
                    $depth += $aim * $amount;
                    break;
                case 'up':
                    $aim -= $amount;
                    break;
                case 'down':
                    $aim += $amount;
                    break;
                default:
                    throw new \Exception("Unexpected direction: $direction");
            }
        }
        return $depth * $position;
    }
}