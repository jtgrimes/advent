<?php

namespace Jtgrimes\Advent\y2016;

use Illuminate\Support\Str;
use Jtgrimes\Advent\Support\RegexUtility;

class Day4 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = '361724';
    public $part2Solution = '482';
    public function part1()
    {
        $input = $this->getInputAsCollectionOfLines();
        return $input->map(function ($line) {
            $parts['name'] = Str::beforeLast($line, '-');
            $parts['sectorID'] = RegexUtility::firstMatch('/-(\d+)/', $line);
            $parts['checksum'] = RegexUtility::firstMatch('/\[(.+)\]/', $line);
            return $parts;
        })->reject(function ($parts) {
            return $this->isDecoy($parts);
        })->pluck('sectorID')->sum();
    }

    public function part2()
    {
        $input = $this->getInputAsCollectionOfLines();
        $words = $input->map(function ($line) {
            $parts['name'] = Str::beforeLast($line, '-');
            $parts['sectorID'] = RegexUtility::firstMatch('/-(\d+)/', $line);
            $parts['checksum'] = RegexUtility::firstMatch('/\[(.+)\]/', $line);
            return $parts;
        })->reject(function ($parts) {
            return $this->isDecoy($parts);
        })->mapWithKeys(function ($code) {
            $letters = str_split($code['name']);
            $move = (int)$code['sectorID'] % 26;
            // 141 is 'a'
            return [$code['sectorID'] => collect($letters)->map(function ($letter) use ($move){
                if($letter == '-') return ' ';
                $char = (int)ord($letter) + (int)$move;
                if ($char > ord('z')) {
                    $char -= 26;
                }
                return chr($char);
            })->implode('')];
        });
        return $words->filter(function ($decoded) {
            return Str::contains($decoded, 'northpole');
        })->keys()->first();
    }

    private function isDecoy($parts)
    {
        return $this->calculateChecksum($parts['name']) != $parts['checksum'];
    }

    private function calculateChecksum($name)
    {
        return collect(str_split($name))->reject(function ($letter) {
                return $letter == '-';
             })
            ->countBy()->map(function ($count, $letter) {

                return ['count' => $count, 'letter' => $letter];
            })
            ->sortBy([
                ['count', 'desc'],
                ['letter', 'asc'],
            ])->pluck('letter')->take(5)->implode('');
    }
}