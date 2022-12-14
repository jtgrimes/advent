<?php

namespace Jtgrimes\Advent\y2015;

use Jtgrimes\Advent\Day;

class Day4 extends Day
{
    protected $input = 'bgvyzdsv';

    public $part1Solution = '254575';
    public $part2Solution = '1038736';

    public function part1()
    {
        return $this->findHashStartingWith('00000');
    }

    public function part2()
    {
        return $this->findHashStartingWith('000000');
    }

    private function findHashStartingWith($needle)
    {
        $found = false;
        $counter = 0;
        while (! $found) {
            $counter++;
            $hash = md5($this->input.$counter);
            if (str_starts_with($hash, $needle)) {
                $found = true;
            }
        }
        return $counter;
    }
}