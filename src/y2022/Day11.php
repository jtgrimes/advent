<?php

namespace Jtgrimes\Advent\y2022;

use Jtgrimes\Advent\Support\ItemThrowingMonkey;

class Day11 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = '110264';
    public $part2Solution = '23612457316';

    public function part1()
    {
        return $this->calculate(20, true);
    }

    public function part2()
    {
        return $this->calculate(10000, false);

    }

    private function calculate($rounds, $feelRelieved )
    {
        $monkeys = $this->buildMonkeys();
        foreach (range (1,$rounds) as $round) {
            foreach ($monkeys as $monkey) {
                $monkey->throwAllItems($monkeys, $feelRelieved);
            }
        }
//        foreach ($monkeys as $monkey) {$monkey->dumpItems();}
        return $this->calculateMonkeyBusiness($monkeys);
    }

    private function buildMonkeys()
    {
        $lines = $this->getInputAsCollectionOfLines(); // don't forget, this throws out blank lines
        $monkeys = $lines->chunk(6)->mapWithKeys(function ($lines) {
            // reindex
            $lines = array_values($lines->toArray());
            $monkey = new ItemThrowingMonkey($lines);
            return [$monkey->id => $monkey];

        });
        return $monkeys;
    }

    private function calculateMonkeyBusiness($monkeys)
    {
        $troublesome = $monkeys->sortByDesc('inspections')->take(2)->pluck('inspections');
        return $troublesome[0] * $troublesome[1];
    }
}