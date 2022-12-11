<?php

namespace Jtgrimes\Advent\y2022;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day10 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = 11720;
    // part 2 = ERCREPCJ
    public function part1()
    {
        $calculateStrengthAt = [20, 60, 100, 140, 180, 220];
        $instructions = $this->getInputAsCollectionOfLines();
        $strengths = $this->calculateStrengthsThru(max($calculateStrengthAt), $instructions);
        $cumulative = 0;
        foreach ($calculateStrengthAt as $time) {
            echo ("Time: $time, Strength: {$strengths[$time]}\n");
            $cumulative += $time * $strengths[$time];
        }
        return $cumulative;
    }

    public function part2()
    {
        $instructions = $this->getInputAsCollectionOfLines();
        $strengths = $this->calculateStrengthsThru(240, $instructions);
        var_dump($strengths);
        $lit = [];
        foreach (range(0,240) as $cycle) {
            if (abs($strengths[$cycle + 1] - ($cycle % 40)) <=1) { // within 1 pixel either way
                $lit[$cycle] = '#';
            } else {
                $lit[$cycle] = '.';
            }
        }
        foreach ($lit as $i => $pixel) {
            echo ($pixel);
            if ($i % 40 == 39) {
                echo "\n";
            }
        }
    }

    private function calculateStrengthsThru(int $time, Collection $instructions)
    {
        $strengths = [];
        $strength = 1;
        $instructionID = 0;
        $addInProgress = 0;
        $strengths[1] = 1;
        foreach (range(2, $time + 2) as $cycle) {

            if ($addInProgress) {
                $strength += $addInProgress;
                $addInProgress = 0;
            } else {
                $instruction = $instructions[$instructionID];
                $instructionID++;
                if (Str::contains($instruction, 'addx')) {
                    $addInProgress = (int)trim(explode(' ', $instruction)[1]);
                }
            }
            $strengths[$cycle] = $strength;
        }
        return $strengths;
    }
}