<?php

namespace Jtgrimes\Advent;

abstract class Day
{
    private $inputDir = 'd:\code\jtgrimes\advent\input\\';
    protected $year;
    protected $day;

    public function getInputAsArrayOfCharacters()
    {
        $input = file_get_contents($this->inputDir."{$this->year}/day{$this->day}");
        return str_split($input);

    }

    public abstract function part1();
    public abstract function part2();
}