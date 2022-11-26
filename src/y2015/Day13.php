<?php

namespace Jtgrimes\Advent\y2015;

use Jtgrimes\Advent\Day;
use Jtgrimes\Advent\y2015\Support\Combinator;

class Day13 extends Day
{
    protected $year = 2015;
    protected $day = 13;
    protected $guests = [];
    protected $scores = [];

    public function part1()
    {
        $maxScore = 0;
        $this->readInputData();
        $possibilities = (new Combinator($this->guests))->permutations();
        foreach ($possibilities as $option) {
            $score = $this->calculateScore($option);
            if ($score > $maxScore) {
                $maxScore = $score;
            }
        }
        return $maxScore;

    }

    public function part2()
    {
        $maxScore = 0;
        $this->readInputData();
        $this->addMeToLists();
        $possibilities = (new Combinator($this->guests))->permutations();
        foreach ($possibilities as $option) {
            $score = $this->calculateScore($option);
            if ($score > $maxScore) {
                $maxScore = $score;
            }
        }
        return $maxScore;
    }

    private function readInputData()
    {
        $lines = $this->getInputAsArrayOfLines();
        foreach ($lines as $line) {
            $words = explode(' ', trim($line));
            $guest1 = $words[0];
            $sign = $words[2] == 'gain' ? 1: -1;
            $points = (int)$words[3] * $sign;
            $guest2 = str_replace('.', '', $words[10]);

            if (! in_array($guest1, $this->guests)) {
                $this->guests[] = $guest1;
            }

            $this->scores[$guest1][$guest2] = $points;
        }
    }

    private function calculateScore(array $option)
    {
        $score = 0;
        foreach ($option as $i => $guest) {
            if ($i > 0) {
                $previousGuest = $option[$i - 1];
            } else {
                $previousGuest = $option[count($option) - 1];
            }
            $score += $this->scores[$guest][$previousGuest];
            $score += $this->scores[$previousGuest][$guest];
        }
        return $score;
    }

    private function addMeToLists()
    {
        $this->guests[] = 'me';
        foreach ($this->scores as $guest => $otherGuestList) {
            $this->scores[$guest]['me'] = 0;
            $this->scores['me'][$guest] = 0;
        }

    }
}