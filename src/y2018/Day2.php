<?php

namespace Jtgrimes\Advent\y2018;

use Jtgrimes\Advent\Support\StringUtility;

class Day2 extends \Jtgrimes\Advent\Day
{

    public $part1Solution = '8715';
    public $part2Solution = 'fvstwblgqkhpuixdrnevmaycd';

    public function part1()
    {
        $input = $this->getInputAsArrayOfLines();
        $twos =  StringUtility::countMatchingStrings($input, function ($string) {
            $letters = str_split($string);
            $counts = array_count_values($letters);
            if (in_array(2, $counts)) {
                return true;
            }
        });
        $threes =  StringUtility::countMatchingStrings($input, function ($string) {
            $letters = str_split($string);
            $counts = array_count_values($letters);
            if (in_array(3, $counts)) {
                return true;
            }
        });
        return $twos * $threes;
    }

    public function part2()
    {
        $input = $this->getInputAsCollectionOfLines();
        foreach ($input as $i => $box) {
            foreach (range($i+1, count($input)-1) as $second) {
                $lettersFirst = str_split($box);
                $lettersSecond = str_split($input[$second]);
                $diff = array_diff_assoc($lettersFirst, $lettersSecond);
                if (count($diff) == 1) {
                    return implode('', array_intersect_assoc($lettersFirst, $lettersSecond));
                }
            }
        }
    }
}