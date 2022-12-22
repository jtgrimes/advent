<?php

namespace Jtgrimes\Advent\y2022;

use Illuminate\Support\Str;
use Jtgrimes\Advent\Support\Calculator;
use Jtgrimes\Advent\Support\RegexUtility;

class Day21 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = '194058098264286';
    public $part2Solution = '3592056845086';
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
        $monkeys = $this->buildMonkeys();
        $root = $monkeys->get('root');
        $root['operation'] = '=';
        $monkeys['root'] = $root;
        $equation = "#root#";
        while (Str::contains($equation, '#')) {
           $equation = $this->replaceEquation($equation, $monkeys);
           $equation = Str::replace('#humn#', 'HUMN', $equation);
        }
        $tidy = $this->tidyEquation($equation);
        echo("$tidy\n");
        // this is as simplified as I can get it using simple techniques
        // ... solved from here by brute force
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

    private function replaceEquation(mixed $equation, $monkeys)
    {
        $match = RegexUtility::firstMatch('/#(\w+)#/', $equation);
        $node = $monkeys->get($match);
        return $this->substitute($equation, $match, $node);
    }

    private function substitute($equation, $nodeID, $node)
    {
        if (array_key_exists('value', $node)) {
            return Str::replace('#'.$nodeID.'#', $node['value'], $equation);
        }
        $new = "(#".$node['first']."# ".$node['operation']." #".$node['second']."#)";
        return Str::replace('#'.$nodeID.'#', $new, $equation);
    }

    private function tidyEquation(string $equation)
    {
        $done = false;
        while (!$done) {
            $cleanThis = RegexUtility::firstMatch('/(\(-?\d+ . -?\d+\))/', $equation);
            if ($cleanThis) {
                list($first, $operation, $second) = explode(' ', $cleanThis);
                $value = Calculator::calculate((int)Str::remove('(',$first), (int)Str::remove(')',$second), $operation);
                $equation = Str::replace($cleanThis, $value, $equation);
            } else {
                $done = true;
            }
        }
        return $equation;
    }
}