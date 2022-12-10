<?php

namespace Jtgrimes\Advent\y2022;

class Day4 extends \Jtgrimes\Advent\Day
{

    public $part1Solution = '509';
    public $part2Solution = '870';
    public function part1()
    {
        $matches = 0;
        $pairs = $this->buildPairs();
        foreach ($pairs as $pair) {
            if ($this->fullOverlap($pair)) {
                $matches++;
            }
        }
        return $matches;
    }

    public function part2()
    {
        $matches = 0;
        $pairs = $this->buildPairs();
        foreach ($pairs as $pair) {
            if ($this->partialOverlap($pair)) {
                $matches++;
            }
        }
        return $matches;
    }

    private function buildPairs()
    {
        $pairs = [];
        $input = $this->getInputAsArrayOfLines();
        foreach ($input as $line) {
            $parts = explode(',', $line);
            foreach ($parts as $elf => $range) {
                list($pair[$elf]['low'], $pair[$elf]['high']) = explode('-', $range);
            }
            $pairs[] = $pair;
        }
        return $pairs;
    }

    private function fullOverlap(array $pair)
    {
        // this could be nicer, but it does the job
        return (($pair[0]['low'] >= $pair[1]['low'] && $pair[0]['high'] <= $pair[1]['high'])
            || ($pair[1]['low'] >= $pair[0]['low'] && $pair[1]['high'] <= $pair[0]['high']));
    }

    private function partialOverlap(array $pair)
    {
        // this could be nicer, but it does the job
        return ($pair[0]['low'] >= $pair[1]['low'] && $pair[0]['low'] <= $pair[1]['high'])
        || ($pair[0]['high'] >= $pair[1]['low'] && $pair[0]['high'] <= $pair[1]['high'])
        || ($pair[1]['low'] >= $pair[0]['low'] && $pair[1]['low'] <= $pair[0]['high'])
        || ($pair[1]['high'] >= $pair[0]['low'] && $pair[1]['high'] <= $pair[0]['high']);

    }
}