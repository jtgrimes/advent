<?php

namespace Jtgrimes\Advent\y2016;

use Illuminate\Support\Str;

class Day3 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = '1032';
    public $part2Solution = '1838';
    public function part1()
    {
        $lines = collect($this->getInputAsArrayOfLines()); // we don't want this trimmed
        return $lines->reject(function ($line) {
            return (empty(trim($line)));
        })->reduce(function ($carry, $line) {
            $sides = $this->parseLines($line);
            return $carry + (int)$this->validSides($sides);
        });
    }

    public function part2()
    {   $lines = collect($this->getInputAsArrayOfLines()); // we don't want this trimmed
        $linesCount = $lines->count();
        $sides = [];
        $lines->reject(function ($line) {
            return (empty(trim($line)));
        })->each(function ($line, $i) use (&$sides, $linesCount) {
            $parts = $this->parseLines($line);
            $sides[$i] = $parts[0];
            $sides[$i + $linesCount] = $parts[1];
            $sides[$i + 2 * $linesCount] = $parts[2];
        });
        return (collect($sides))->sortKeys()->chunk(3)
            ->reduce(function($carry, $triangle) {
                return $carry + (int)$this->validSides($triangle->values()->toArray());
            });
    }

    private function parseLines($line)
    {
        $parts[0] = (int)Str::substr($line, 2,3);
        $parts[1] = (int)Str::substr($line, 7,3);
        $parts[2] = (int)Str::substr($line, 12,3);
        return $parts;
    }

    private function validSides($sides)
    {
        list($a, $b, $c) = $sides;
        return ($a + $b > $c) && ($a + $c > $b) && ($b + $c > $a);
    }
}