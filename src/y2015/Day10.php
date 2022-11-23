<?php

namespace Jtgrimes\Advent\y2015;

use Jtgrimes\Advent\Day;

class Day10 extends Day
{
    protected $year = 2015;
    protected $day = 10;

    protected $input = '1113222113';

    public function part1()
    {
        $word = $this->input;
        foreach (range(1,40) as $i) {
            $word = $this->speakAndSay($word);
        }
        return strlen($word);
    }

    public function part2()
    {
        $word = $this->input;
        foreach (range(1,50) as $i) {
            $word = $this->speakAndSay($word);
        }
        return strlen($word);
    }

    private function speakAndSay(string $word)
    {
        $chars = str_split($word);
        $cumulative = '';
        $workingDigit = '';
        $workingCount = 0;
        foreach ($chars as $char) {
            if ($char == $workingDigit) {
                $workingCount++;
            } else {
                if ($workingCount != 0) {
                    // don't include the first 0 in our string;
                    $cumulative.= $workingCount.$workingDigit;
                }
                $workingDigit = $char;
                $workingCount = 1;
            }
        }
        // add whatever we had working at the end.
        $cumulative.= $workingCount.$workingDigit;
        return $cumulative;

    }
}