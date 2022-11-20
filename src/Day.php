<?php

namespace Jtgrimes\Advent;

use Illuminate\Support\Collection;

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

    public function getInputAsArrayOfLines()
    {
        return file($this->inputDir."{$this->year}/day{$this->day}");
    }

    public function getInputAsCollectionOfLines()
    {
        return new Collection($this->getInputAsArrayOfLines());
    }

    public abstract function part1();
    public abstract function part2();
}