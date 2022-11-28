<?php

namespace Jtgrimes\Advent;

use Illuminate\Support\Collection;

abstract class Day
{
    private $inputDir = 'd:\code\jtgrimes\advent\input\\';

    public function getYear()
    {
        return $this->getMatchFromClassName('/Jtgrimes\\\\Advent\\\\y(\d*)\\\\/');
    }

    public function getDay()
    {
        return $this->getMatchFromClassName('/Jtgrimes\\\\Advent\\\\y\d*\\\\Day(\d*)/');
    }

    private function getMatchFromClassName($regex)
    {
        $matches = [];
        if (preg_match($regex, static::class, $matches)) {
            return $matches[1];
        }
    }

    public function getInputAsArrayOfCharacters()
    {
        $input = file_get_contents($this->inputDir."{$this->getYear()}/day{$this->getDay()}");
        return str_split($input);
    }

    public function getInputAsArrayOfLines()
    {
        return file($this->inputDir."{$this->getYear()}/day{$this->getDay()}");
    }

    public function getInputAsCollectionOfLines()
    {
        return new Collection($this->getInputAsArrayOfLines());
    }

    public abstract function part1();
    public abstract function part2();
}