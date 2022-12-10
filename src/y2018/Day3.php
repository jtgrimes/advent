<?php

namespace Jtgrimes\Advent\y2018;

use Jtgrimes\Advent\Support\StringUtility;

class Day3 extends \Jtgrimes\Advent\Day
{

    public $part1Solution = '115348';
    public $part2Solution = '188';
    public function part1()
    {
        $claims = $this->buildClaims();
        $visits = $this->fillVisits($claims);
        $cumulative = 0;
        foreach ($visits as $row) {
            foreach ($row as $cell) {
                if ($cell > 1) {
                    $cumulative ++;
                }
            }
        }
        return $cumulative;
    }

    public function part2()
    {
        $claims = $this->buildClaims();
        $visits = $this->fillVisits($claims);
        // find a claim that's only 1s (no overlap)
        return $claims->skipUntil(function ($claim) use ($visits) {
            list($left, $top) = explode(',', $claim['starts']);
            list($width, $height) = explode('x', $claim['size']);
            foreach (range($left, (int)$left + (int)$width -1) as $x) {
                foreach (range($top, (int)$top+ (int)$height -1) as $y) {
                    if ($visits[$x][$y] != 1) {
                        return false;
                    }
                }
            }
            return true;
        })->keys()->first();
    }

    private function buildClaims()
    {
        $lines = $this->getInputAsCollectionOfLines();
        return $lines->mapWithKeys(function ($line) {
            $str = new StringUtility($line);
            $id = $str->charactersBetween('#', ' ');
            $start = $str->charactersBetween('@ ', ':');
            $size = $str->charactersBetween(': ');
            return [$id => ['starts' => $start, 'size' => $size]];
        });
    }

    private function fillVisits($claims)
    {
        $visits = [];
        $claims->each(function ($claim) use (&$visits) {
            list($left, $top) = explode(',', $claim['starts']);
            list($width, $height) = explode('x', $claim['size']);
            foreach (range($left, (int)$left + (int)$width -1) as $x) {
                foreach (range($top, (int)$top+ (int)$height -1) as $y) {
                    if (! array_key_exists($x, $visits) ||  ! array_key_exists($y, $visits[$x])) {
                        // if it's not already there, initialize it
                        $visits[$x][$y] = 0;
                    }
                    $visits[$x][$y] += 1;
                }
            }
        });
        return $visits;
    }

}