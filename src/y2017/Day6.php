<?php

namespace Jtgrimes\Advent\y2017;

use Illuminate\Support\Collection;

class Day6 extends \Jtgrimes\Advent\Day
{

    public $part1Solution = '4074';
    public $part2Solution = '2793';
    public function part1()
    {
        $input = $this->getInputAsString();
        $banks = collect(explode(chr(9), $input));
        $seenStates = collect($this->currentState($banks));
        $done = false;
        while (! $done) {
            $banks = $this->distributeBanks($banks);
            $done = $this->checkDone($banks, $seenStates);
            $currentState = $this->currentState($banks);
            $seenStates->push($currentState);
        }
        return $seenStates->count() - 1;
    }

    public function part2()
    {
        $input = $this->getInputAsString();
        $banks = collect(explode(chr(9), $input));
        $seenStates = collect($this->currentState($banks));
        $done = false;
        while (! $done) {
            $banks = $this->distributeBanks($banks);
            $done = $this->checkDone2($banks, $seenStates);
            $currentState = $this->currentState($banks);
            $seenStates->push($currentState);
        }
        // so the current state is the one we've matched
        $landed = $seenStates->filter(function ($state) use ($currentState) {
            return $state == $currentState;
        })->keys();
        var_dump($landed);
        return $landed[2] - $landed[1];
    }

    private function checkDone(Collection $banks, Collection &$seenStates)
    {
        return $seenStates->contains($this->currentState($banks));
    }

    private function checkDone2(Collection $banks, Collection &$seenStates)
    {
        return $seenStates->countBy()->contains(3); // do we have two extra copies of any value?
    }

    private function currentState(Collection $banks)
    {
        return implode(',', $banks->all());
    }

    private function distributeBanks(Collection $banks)
    {
        $max = $banks->max();
        $bankCount = $banks->count();
        $startingBank = $banks->filter(function ($value) use ($max) {return $value == $max;})->keys()->first();
        $banks[$startingBank] = 0;
        for ($i = 1; $i <= $max; $i++) {
            $giveTo = ($startingBank + $i) % $bankCount;
            $banks[$giveTo] = $banks->get($giveTo) + 1;
        }
        return $banks;
    }
}