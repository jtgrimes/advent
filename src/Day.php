<?php

namespace Jtgrimes\Advent;

use Illuminate\Support\Collection;
use Jtgrimes\Advent\Support\RegexUtility;

abstract class Day
{
    private $inputDir = 'd:\code\jtgrimes\advent\input\\';

    public $part1Solution;
    public $part2Solution;

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
        return RegexUtility::firstMatch($regex, static::class);
    }

    private function inputFileName()
    {
        return $this->inputDir."{$this->getYear()}/day{$this->getDay()}";
    }

    public function getInputAsString()
    {
        return trim(file_get_contents($this->inputFileName()));
    }

    public function getInputAsArrayOfCharacters()
    {
        $input = trim(file_get_contents($this->inputFileName()));
        return str_split($input);
    }

    public function getInputAsArrayOfLines()
    {
        return file($this->inputFileName());
    }

    public function getInputAsCollectionOfLines() : Collection
    {
        return (new Collection($this->getInputAsArrayOfLines()))
            ->map(function ($line) {
                return trim($line);
            })->reject(function ($line){
                return empty($line);
            });
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

    public function getInputAsCharacterGrid()
    {
        $lines = $this->getInputAsArrayOfLines();
        foreach ($lines as $line) {
            if (! empty($line)) {
                $grid[] = str_split(trim($line));
            }
        }
        return $grid;
    }

    public abstract function part1();
    public abstract function part2();
}