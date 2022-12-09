<?php

namespace Jtgrimes\Advent\y2015;

use Jtgrimes\Advent\Day;

class Day12 extends Day
{

    public $part1Solution = '156366';
    public $part2Solution = '96852';

    public function part1()
    {
        $input = $this->getInputAsJSONArray();
        return $this->sumValuesInInput($input);
    }

    public function part2()
    {
        $input = $this->getInputAsJSONObject();
        return $this->sumValuesInInput($input, true);
    }

    private function sumValuesInInput(mixed $input, $excludeRed = false)
    {
        if (is_numeric($input)) {
            return $input;
        }
        if (is_string($input)) {
            return 0;
        }
        if (is_array($input)) {
            $cumulative = 0;
            foreach ($input as $element) {
                $cumulative += $this->sumValuesInInput($element, $excludeRed);
            }
            return $cumulative;
        }
        // we have an object ... check for "red" values
        $asArray = (array)$input;
        if ($excludeRed && in_array('red', $asArray)) {
            return 0;
        }
        return $this->sumValuesInInput($asArray, $excludeRed);
    }
}