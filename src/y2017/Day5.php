<?php

namespace Jtgrimes\Advent\y2017;

class Day5 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = '372671';
    public $part2Solution = '25608480';
    public function part1()
    {
        $instructions = collect($this->getInputAsArrayOfLines())->transform(function($item) {
            return (int)trim($item);
        });
        $position = $instructions->keys()->first();
        $jump = $instructions->first();
        $i = 1;
        while ($instructions->keys()->contains($position + $jump)) {
            $nextPosition = $position + $jump;
            $current = $instructions->get($position);
            $instructions[$position] = $current + 1;
            $position = $nextPosition;
            $jump = $instructions->get($nextPosition);
            $i++;
        }
        return $i;
    }

    public function part2()
    {
        $instructions = collect($this->getInputAsArrayOfLines())->transform(function($item) {
            return (int)trim($item);
        });
        $position = $instructions->keys()->first();
        $jump = $instructions->first();
        $i = 1;
        while ($instructions->keys()->contains($position + $jump)) {
            $nextPosition = $position + $jump;
            $current = $instructions->get($position);
            $instructions[$position] = $current + ($jump >= 3 ? -1 : 1);
            $position = $nextPosition;
            $jump = $instructions->get($nextPosition);
//            echo "$i   Position: $position, Jump: $jump, Next Position: $nextPosition\n";
            $i++;
        }
//        var_dump($instructions);
        return $i;
    }
}