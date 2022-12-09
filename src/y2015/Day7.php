<?php

namespace Jtgrimes\Advent\y2015;

use Jtgrimes\Advent\Day;
use Jtgrimes\Advent\y2015\Support\Circuit;

class Day7 extends Day
{
    public $part1Solution = '956';
    public $part2Solution = '40149';

    public function part1()
    {
        $lines = $this->getInputAsCollectionOfLines();
        $circuit = new Circuit($lines);
        return $circuit->resolve('a');
    }

    public function part2()
    {
        $lines = $this->getInputAsCollectionOfLines();
        $circuit = new Circuit($lines);
        $circuit->forceInput('b', 956);
        return $circuit->resolve('a');
    }
}
