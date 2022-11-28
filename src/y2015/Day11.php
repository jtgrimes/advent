<?php

namespace Jtgrimes\Advent\y2015;

use Jtgrimes\Advent\Day;

class Day11 extends Day
{
    public function part1()
    {
        $password = 'hxbxwxba';
        while (! $this->isValid($password)) {
            $password = $this->incrementString($password);
        }
        return $password;
    }

    public function part2()
    {
        $password = $this->incrementString($this->part1());
        while (! $this->isValid($password)) {
            $password = $this->incrementString($password);
        }
        return $password;
    }

    public function incrementString(string $str)
    {
        // this is super hacky and should be cleaned up.
        $chars = str_split($str);
        $last = count($chars)-1;
        if ($chars[$last] < 'z') {
            $chars[$last]++;
            return implode('', $chars);
        }
        unset($chars[$last]);
        return $this->incrementString(implode('', $chars)).'a';

    }

    private function isValid(string $password)
    {
        if (str_contains($password, 'i') || str_contains($password, 'l') || str_contains($password, 'o')) {
            return false;
        }
        if (! $this->hasRunOf3($password)) {
            return false;
        }
        return $this->hasTwoDoubleLetters($password);
    }

    private function hasRunOf3(string $password)
    {
        $letters = str_split($password);
        foreach ($letters as $position => $char) {
            if ($position < 2 ) {
                // no op
            } else {
                if ($letters[$position-1] == $this->decrementLetter($char) && $letters[$position-2] == $this->decrementLetter($char, 2)) {
                    return true;
                } 
            }
        }
        return false;
    }

    private function hasTwoDoubleLetters(string $password)
    {
        $first = 0;
        $letters = str_split($password);
        foreach ($letters as $position => $char) {
            if ($position < 1 ) {
                // no op
            } else {
                if ($char == $letters[$position - 1]) {
                    if ($first) {
                        if ($position > $first + 1) { //check for overlap
                            return true;
                        }
                    } else {
                        $first = $position;
                    }
                }
            }
        }
        return false;
    }

    private function incrementLetter($letter, $amount = 1) {
        $newLetter = (ord($letter) + $amount) % ord('z');
        return chr($newLetter);
    }

    private function decrementLetter($letter, $amount = 1) {
        return chr(ord($letter) - $amount);
    }
}