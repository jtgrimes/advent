<?php

namespace Jtgrimes\Advent\y2021;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day8 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = '539';
    public $part2Solution = '1084606';

    private $circuitsToDigits = [
        'cf' => 1,
        'acf' => 7,
        'bcdf' => 4,
        'abcdefg' => 8,
        'acdfg' => 3,
        'abcdfg' => 9,
        'abcefg' => 0,
        'abdefg' => 6,
        'acdeg' => 2,
        'abdfg' => 5,
        ];

    public function part1()
    {
        $lines = $this->getInputAsArrayOfLines();
        foreach ($lines as $line) {
            $outputValues[] = explode(' ', trim(explode('|', trim($line))[1]));
        }
        $matches = 0;
        foreach ($outputValues as $outputValue) {
            foreach ($outputValue as $digit) {
                if (strlen($digit) == 2 // 1
                    || strlen($digit) == 3 // 7
                    || strlen($digit) == 4 // 4
                    || strlen($digit) == 7 // 8
                ) {
                    $matches++;
                }
            }
        }
        return $matches;
    }

    public function part2()
    {
        $lines = $this->getInputAsArrayOfLines();
        $total = 0;
        foreach ($lines as $line) {
            $parts = explode('|', trim($line));
            // we're gonna alpha sort every string so that we can do direct conversion
            $digits = collect(explode(' ', trim($parts[0])));
            $digits = $digits->map(function ($item) {
                return $this->alphaSortString($item);
            });
            $outputValues = collect(explode(' ', trim($parts[1])));
            $outputValues = $outputValues->map(function ($item) {
                return $this->alphaSortString($item);
            });
            $table = $this->buildTranslateTable($digits);
            $total += (int)$outputValues->reduce(function ($carry, $value) use ($table) {
                return $carry . $table[$value];
            });
            // 1102666 is too high
        }
        return $total;
    }

    private function alphaSortString($str)
    {
        $letters = str_split($str);
        asort($letters);
        return implode('',$letters);
    }

    private function buildTranslateTable(Collection $digits)
    {
        $one = $digits->filter(function ($str) {
            return strlen($str) == 2;
        })->first();
        $translation[$one] = '1';

        $seven = $digits->filter(function ($str) {
            return strlen($str) == 3;
        })->first();
        $translation[$seven] = '7';

        $four = $digits->filter(function ($str) {
            return strlen($str) == 4;
        })->first();
        $translation[$four] = '4';

        $eight = $digits->filter(function ($str) {
            return strlen($str) == 7;
        })->first();
        $translation[$eight] = '8';

        $three = $digits->filter(function ($str) use ($seven) {
            return strlen($str) == 5 && $this->containsAllLettersIn($str, $seven);
        })->first();
        $translation[$three] = '3';

        $nine = $digits->filter(function ($str) use ($four) {
            return strlen($str) == 6 && $this->containsAllLettersIn($str, $four);
        })->first();
        $translation[$nine] = '9';

        // limit the collection to things we haven't found yet
        $digits = $digits->reject(function ($item) use ($translation) {
            return in_array($item, array_keys($translation));
        });

        if (count($digits) != 4) {
            throw new \Exception('something went wrong rejecting items');
        }

        $zero = $digits->filter(function ($str) use ($seven) {
            return strlen($str) == 6 && $this->containsAllLettersIn($str, $seven);
        })->first();
        $translation[$zero] = '0';

        $digits = $digits->reject(function ($item) use ($translation) {
            return in_array($item, array_keys($translation));
        });

        $six = $digits->filter(function ($str){
            return strlen($str) == 6;
        })->first();
        $translation[$six] = '6';

        $five = $digits->filter(function ($str) use ($one, $four) {
            // the upper left line and center horizontal line are 4 without 1.
            $bd = implode(array_diff(str_split($four), str_split($one)));
            return strlen($str) == 5 && $this->containsAllLettersIn($str, $bd);
        })->first();
        $translation[$five] = '5';

        $two = $digits->reject(function ($item) use ($translation) {
            return in_array($item, array_keys($translation));
        })->first();
        $translation[$two] = '2';

        return $translation;
    }

    private function containsAllLettersIn($haystack, $needle)
    {
        return Str::containsAll($haystack, str_split($needle));
    }
}