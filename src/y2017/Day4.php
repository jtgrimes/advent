<?php

namespace Jtgrimes\Advent\y2017;

use Jtgrimes\Advent\Support\StringUtility;

class Day4 extends \Jtgrimes\Advent\Day
{

    public $part1Solution = '466';
    public $part2Solution = '251';
    public function part1()
    {
        return StringUtility::countMatchingStrings($this->getInputAsArrayOfLines(), function ($string) {
            return $this->hasNoDuplicateWords($string);
        });
    }

    public function part2()
    {
        return StringUtility::countMatchingStrings($this->getInputAsArrayOfLines(), function ($string) {
            return $this->hasNoDuplicatesOrAnagrams($string);
        });
    }

    private function hasNoDuplicateWords($string)
    {
        $words = explode(' ', trim($string));
        $counts = array_count_values($words);
        if (max($counts) > 1) { // we have a repeat
            return false;
        }
        return true;
    }

    private function hasNoDuplicatesOrAnagrams($string)
    {
        $words = explode(' ', trim($string));
        $alphawords = [];
        // put the "words" in alpha order
        foreach ($words as $word) {
            $asArray = str_split($word);
            asort($asArray);
            $alphawords[] = implode('',$asArray);
        }
        $counts = array_count_values($alphawords);
        if (max($counts) > 1) { // we have a repeat
            return false;
        }
        return true;
    }
}