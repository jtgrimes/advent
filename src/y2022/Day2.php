<?php

namespace Jtgrimes\Advent\y2022;

class Day2 extends \Jtgrimes\Advent\Day
{

    public function part1()
    {
        $input = $this->getInputAsArrayOfLines();
        $cumulative = 0;
        foreach ($input as $line) {
            $parts = explode(' ', trim($line));
            $opponent = $parts[0];
            $me = $parts[1];
            $cumulative += $this->play($opponent, $me);
        }
        return $cumulative;
    }

    public function part2()
    {
        $input = $this->getInputAsArrayOfLines();
        $cumulative = 0;
        foreach ($input as $line) {
            $parts = explode(' ', trim($line));
            $opponent = $parts[0];
            $outcome = $parts[1];
            $me = $this->calculatePlay($opponent, $outcome);
            $cumulative += $this->play($opponent, $me);
        }
        return $cumulative;
    }

    private function play(string $opponent, string $me)
    {
        switch ($me) {
            case 'X': // rock
                return 1 + match ($opponent) {
                        'A' => 3, // rock -> tie
                        'B' => 0, // paper -> loss
                        'C' => 6, // scissors -> win
                };
            case 'Y': // paper
                return 2 + match ($opponent) {
                        'A' => 6, // rock
                        'B' => 3, // paper
                        'C' => 0, // scissors
                    };
            case 'Z': // scissors
                return 3 + match ($opponent) {
                        'A' => 0, // rock
                        'B' => 6, // paper
                        'C' => 3, // scissors
                    };
            default:
                throw new \Exception("Unexpected input: $opponent, $me");
        }
    }

    private function calculatePlay(string $opponent, string $outcome)
    {
        switch ($outcome) {
            case 'X': // lose
                return match ($opponent) {
                        'A' => 'Z', // rock -> scissors
                        'B' => 'X', // paper -> rock
                        'C' => 'Y', // scissors -> paper
                    };
            case 'Y': // tie
                return match ($opponent) {
                    'A' => 'X', // rock -> rock
                    'B' => 'Y', // paper -> paper
                    'C' => 'Z', // scissors -> scissors
                };
            case 'Z': // win
                return match ($opponent) {
                    'A' => 'Y', // rock -> paper
                    'B' => 'Z', // paper -> scissors
                    'C' => 'X', // scissors -> rock
                };
            default:
                throw new \Exception("Unexpected input: $opponent, $outcome");
        }
    }

}