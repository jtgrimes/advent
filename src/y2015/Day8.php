<?php

namespace Jtgrimes\Advent\y2015;

use Jtgrimes\Advent\Day;

class Day8 extends Day
{
    public $part1Solution = '1350';
    public $part2Solution = '2085';

    public function part1()
    {
        $lines = $this->getInputAsArrayOfLines();
        $strlen = 0;
        $altlen = 0;
        foreach ($lines as $i => $line) {
            $original = trim($line);
            $reduce = $this->reduce($original);
            $strlen += strlen($original);
            $altlen += strlen($reduce);
        }
        return $strlen-$altlen;
    }

    public function part2()
    {
        $lines = $this->getInputAsArrayOfLines();
        $strlen = 0;
        $altlen = 0;
        foreach ($lines as $i => $line) {
            $original = trim($line);
            $encoded = $this->encode($original);
            $strlen += strlen($original);
            $altlen += (strlen($encoded) + 2); // two chars for the start/end quotes
        }
        return $altlen - $strlen;
    }

    private function reduce(string $original)
    {
        $unslashed = str_replace('\\'.'\\', '/', $original);
        $deleadquoted = preg_replace('/^"/', '', $unslashed);
        $deendquoted = preg_replace('/"$/', '', $deleadquoted);
        $deunicoded = preg_replace('/\\\x\w\w/', '!', $deendquoted);
        $dequoted = preg_replace('/\\\"/', '"', $deunicoded);
        return $dequoted;
    }

    private function encode(string $original)
    {
        $encoded = '';
        $chars = str_split($original);
        foreach ($chars as $char) {
            $encoded .= $this->encodeChar($char);
        }
        return $encoded;
    }

    private function encodeChar($char)
    {
        switch ($char) {
            case '"': return '\"';
            case '\\': return '\\\\';
            default: return $char;
        }
    }
}
