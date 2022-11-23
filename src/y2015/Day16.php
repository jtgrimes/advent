<?php

namespace Jtgrimes\Advent\y2015;

use Jtgrimes\Advent\Day;
use Jtgrimes\Advent\y2015\Support\AuntSue;

class Day16 extends Day
{
    protected $year = 2015;
    protected $day = 16;

    protected $aunts;

    public function part1()
    {
        $this->createAunts();
        $filter = function ($aunt) {
            return
                ($aunt->children == -1 || $aunt->children == 3) &&
                ($aunt->cats == -1 || $aunt->cats == 7) &&
                ($aunt->samoyeds == -1 || $aunt->samoyeds == 2) &&
                ($aunt->pomeranians == -1 || $aunt->pomeranians == 3) &&
                ($aunt->akitas == -1 || $aunt->akitas == 0) &&
                ($aunt->vizslas == -1 || $aunt->vizslas == 0) &&
                ($aunt->goldfish == -1 || $aunt->goldfish == 5) &&
                ($aunt->trees == -1 || $aunt->trees == 3) &&
                ($aunt->cars == -1 || $aunt->cars == 2) &&
                ($aunt->perfumes == -1 || $aunt->perfumes == 1);
        };
        return $this->aunts->filter($filter)->first()->id;
    }

    public function part2()
    {
        $this->createAunts();
        $filter = function ($aunt) {
            return
                ($aunt->children == -1 || $aunt->children == 3) &&
                ($aunt->cats == -1 || $aunt->cats > 7) &&
                ($aunt->samoyeds == -1 || $aunt->samoyeds == 2) &&
                ($aunt->pomeranians == -1 || $aunt->pomeranians < 3) &&
                ($aunt->akitas == -1 || $aunt->akitas == 0) &&
                ($aunt->vizslas == -1 || $aunt->vizslas == 0) &&
                ($aunt->goldfish == -1 || $aunt->goldfish < 5) &&
                ($aunt->trees == -1 || $aunt->trees > 3) &&
                ($aunt->cars == -1 || $aunt->cars == 2) &&
                ($aunt->perfumes == -1 || $aunt->perfumes == 1);
        };
        return $this->aunts->filter($filter)->first()->id;
    }

    private function createAunts()
    {
        $lines = $this->getInputAsArrayOfLines();
        foreach ($lines as $line) {
            $aunts[] = AuntSue::fromInput($line);
        }
        $this->aunts = collect($aunts);
    }
}