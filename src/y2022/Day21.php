<?php

namespace Jtgrimes\Advent\y2022;

use Jtgrimes\Advent\Support\Calculator;

class Day21 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = '194058098264286';
    public function part1()
    {
        $monkeys = $this->buildMonkeys();

        while (! array_key_exists('value', $monkeys->get('root'))) {
            $monkeys = $this->iterateMonkeys($monkeys);
        }
        return $monkeys->get('root')['value'];
    }

    public function part2()
    {

        $humn = 23000;
        while (1) {
            $monkeys = $this->buildMonkeys();
            $root = $monkeys->get('root');
            $root['operation'] = '=';
            $monkeys['root'] = $root;

            if ($humn % 1000 == 0 ) {
                echo "Human: $humn\n";
            }
            $human = $monkeys->get('humn');
            $human['value'] = $humn;
            $monkeys['humn'] = $human;
            while (! array_key_exists('value', $monkeys->get('root'))) {
                $monkeys = $this->iterateMonkeys($monkeys);
            }
            if ($monkeys->get('root')['value']) {
                return $humn;
            }
            $humn++;
        }
    }

    private function buildMonkeys()
    {
        return $this->getInputAsCollectionOfLines()
            ->mapWithKeys(function ($line) {
                list($key, $operation) = explode(': ',trim($line));
                if (is_numeric($operation)) {
                    return [$key => ['value' => (int)$operation]];
                }
                list ($firstMonkey, $op, $secondMonkey) = explode(' ', $operation);
                return [$key => ['first' => $firstMonkey, 'second' => $secondMonkey, 'operation' => $op]];
            });
    }

    private function iterateMonkeys(mixed $monkeys)
    {
        return $monkeys->mapWithKeys(function ($monkey, $id) use ($monkeys) {
            if (array_key_exists('value', $monkey)) {
                return [$id => $monkey];
            }
            $first = $monkeys->get($monkey['first']);
            $second = $monkeys->get($monkey['second']);
            if (array_key_exists('value', $first) && array_key_exists('value', $second)) {
                return [$id => [
                    'value' => Calculator::calculate($first['value'], $second['value'], $monkey['operation'])
                ]];
            }
            return [$id => $monkey];
        });
    }
}