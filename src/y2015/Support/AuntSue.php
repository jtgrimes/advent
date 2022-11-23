<?php

namespace Jtgrimes\Advent\y2015\Support;

class AuntSue
{
    public $id;
    public $children = -1;
    public $cats = -1;
    public $samoyeds = -1;
    public $pomeranians = -1;
    public $akitas = -1;
    public $vizslas = -1;
    public $goldfish = -1;
    public $trees = -1;
    public $cars = -1;
    public $perfumes = -1;

    public function __construct($values)
    {
        foreach ($values as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function fromInput($line)
    {
        $matches = [];
        preg_match('/Sue (\d*)/', $line, $matches);
        $id = $matches[1];
        $values['id'] = $id;
        $updatedLine = str_replace("Sue $id: ", '', $line );
        $parts = explode(', ', $updatedLine);
        foreach ($parts as $part) {
            $subParts = explode(': ', $part);
            $values[$subParts[0]] = $subParts[1];
        }

        return new self($values);
    }

}