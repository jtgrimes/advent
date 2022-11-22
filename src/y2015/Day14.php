<?php

namespace Jtgrimes\Advent\y2015;

use Jtgrimes\Advent\Day;
use Jtgrimes\Advent\y2015\Day14\Reindeer;

class Day14 extends Day
{
    protected $year = 2015;
    protected $day = 14;

    public function part1()
    {
        $reindeer = $this->getReindeer();

        $reindeer->each(function (Reindeer $reindeer) {
            $reindeer->turns(2503);
        });
        $positions = $reindeer->map(function (Reindeer $reindeer) {
            return $reindeer->position;
        });
        return $positions->max();
    }

    public function part2()
    {
        $reindeer = $this->getReindeer();
        $scores = $reindeer->mapWithKeys(function (Reindeer $r) {
            return [$r->name => 0];
        });
        foreach (range(1,2503) as $turns) {
            $reindeer->each->tick();
            $leadPosition = $reindeer->map(function (Reindeer $reindeer) {
                return $reindeer->position;
            })->max();
            $leaders = $reindeer->where('position', $leadPosition);
            $leaders->each(function ($r) use ($scores) {
                $scores[$r->name] = $scores[$r->name]+1;
            });
        }
        return $scores->max();
    }

    private function getReindeer()
    {
        return collect([
            new Reindeer('Vixen', 8, 8, 53),
            new Reindeer('Blitzen', 13, 4, 49),
            new Reindeer('Rudolph', 20, 7, 132),
            new Reindeer('Cupid', 12, 4, 43 ),
            new Reindeer('Donner', 9 , 5, 38 ),
            new Reindeer('Dasher', 10, 4, 37 ),
            new Reindeer('Comet', 3 , 37, 76),
            new Reindeer('Prancer', 9 , 12, 97),
            new Reindeer('Dancer', 37, 1, 36 ),
        ]);
    }
}