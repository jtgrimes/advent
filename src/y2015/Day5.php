<?php

namespace Jtgrimes\Advent\y2015;

use Jtgrimes\Advent\Day;

class Day5 extends Day
{
    public $part1Solution = '255';
    public $part2Solution = '55';

    public function part1()
    {
        return $this->loopOverStrings('isNice');
    }

    public function part2()
    {
        return $this->loopOverStrings('day2');
    }

    private function loopOverStrings($testFunction)
    {
        $counter = 0;
        $lines = $this->getInputAsArrayOfLines();
        foreach ($lines as $line) {
            if ($this->$testFunction($line)) {
                $counter++;
            }
        }
        return $counter;
    }

    private function isNice(mixed $line)
    {
        if ($this->hasInvalidCharacters($line)) {
            return false;
        }
        if ( ! $this->has3Vowels($line)) {
            return false;
        }
        return $this->hasDuplicateLetters($line);
    }

    private function hasInvalidCharacters($line)
    {
        return str_contains($line, 'ab')
            || str_contains($line, 'cd')
            || str_contains($line, 'pq')
            || str_contains($line, 'xy');
    }

    private function has3Vowels(mixed $line)
    {
        $letters = str_split($line);
        $vowels = 0;
        foreach ($letters as $char) {
            $vowels += in_array($char, ['a', 'e', 'i', 'o', 'u']) ? 1 : 0;
            if ($vowels >= 3) {
                return true;
            }
        }
        return false;
    }

    private function hasDuplicateLetters(mixed $line, $spacing = 1)
    {
        $letters = str_split($line);
        foreach ($letters as $position => $char) {
            if ($position < $spacing ) {
                // no op
            } else {
                if ($char == $letters[$position - $spacing]) {
                    return true;
                }
            }
        }
        return false;

    }

    private function day2($line)
    {
        if (! $this->hasDuplicateLetters($line, 2)) {
            return false;
        }
        return $this->hasMagicLetterPair($line);
    }

    private function hasMagicLetterPair($line)
    {
        $letters = str_split($line);
        $len = count($letters);

        foreach ($letters as $position => $letter) {
            if ($position > $len - 4) {
                // there aren't enough letters left to match conditions
                return false;
            }
            $nextLetter = $letters[$position + 1];
            $lookingFor = $letter . $nextLetter;
            if (str_contains(substr($line, $position+2), $lookingFor)) {
                return true;
            }
        }
        // shouldn't get here, but ...
        return false;
    }

}