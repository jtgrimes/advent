<?php

namespace Jtgrimes\Advent\Support;

use Illuminate\Support\Collection;

class ItemThrowingMonkey
{
    public int $id;
    public int $inspections = 0;

    private array $items;
    private $operation;
    public int $testDivisibleBy;
    private int $onTrue;
    private int $onFalse;

    private int $ultramodulo;
    public function __construct($lines)
    {
        $this->id = RegexUtility::firstMatch('/Monkey (\d):/', $lines[0]);
        $this->items = explode(', ', RegexUtility::firstMatch('/Starting items: (.+)/', $lines[1]));
        $this->operation = $this->buildFunction(RegexUtility::firstMatch('/Operation: (.+)/', $lines[2]));
        $this->testDivisibleBy = RegexUtility::firstMatch('/divisible by (\d+)/', $lines[3]);
        $this->onTrue = (int)RegexUtility::firstMatch('/throw to monkey (\d)/', $lines[4]);
        $this->onFalse = (int) RegexUtility::firstMatch('/throw to monkey (\d)/', $lines[5]);

    }

    public function throwAllItems(Collection $monkeys, $feelRelieved = true)
    {
        $this->ultramodulo = $monkeys->pluck('testDivisibleBy')->reduce(function ($carry, $num) {
            return $carry * $num;
        }, 1);
        foreach ($this->items as $i => $item)
        {
            $item = $this->inspect((int)$item, $feelRelieved);
            $nextID = $this->getNextMonkeyID($item);
            $this->throwItem($item, $monkeys[$nextID]);
//            echo ("Throwing $item from $this->id to $nextID\n");
            unset($this->items[$i]);
        }
    }

    private function buildFunction(string $input)
    {
        $parts = explode(' ', $input);
        return function (int $value) use ($parts) {
            $part4 = $parts[4] == 'old' ? $value : $parts[4];
            if ($parts[3] == '+') {
                return ($value + $part4) % $this->ultramodulo;
            }
            return ($value * $part4) % $this->ultramodulo;
        };
    }

    private function inspect(int $item, $feelRelieved)
    {
        $item = ($this->operation)($item);
        if ($feelRelieved) {
            $item = intdiv($item, 3);
        }
        $this->inspections ++;
        return $item;
    }

    private function getNextMonkeyID(int $item)
    {
        if (($item % $this->testDivisibleBy) == 0) {
            return $this->onTrue;
        }
        return $this->onFalse;
    }

    private function throwItem(int $item, $monkey)
    {
        $monkey->items[] = $item;
    }

    public function dumpItems()
    {
        echo implode(', ', $this->items). "\n";
    }


}

