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

    public function getInputAsString()
    {
        return trim(file_get_contents($this->inputFileName()));
    }

    public function getInputAsArrayOfCharacters()
    {
        $input = file_get_contents($this->inputFileName());
        return str_split($input);
    }

    public function getInputAsArrayOfLines()
    {
        return file($this->inputFileName());
    }

    public function getInputAsCollectionOfLines()
    {
        return new Collection($this->getInputAsArrayOfLines());
    }

    public function getInputAsJSONArray()
    {
        $input = file_get_contents($this->inputFileName());
        return json_decode($input, true);
    }

    public function getInputAsJSONObject()
    {
        $input = file_get_contents($this->inputFileName());
        return json_decode($input, false);
    }

    private function inputFileName()
    {
        return $this->inputDir."{$this->getYear()}/day{$this->getDay()}";
    }

    public abstract function part1();
    public abstract function part2();
}