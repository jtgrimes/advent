<?php

namespace Jtgrimes\Advent\y2022;

class Day5 extends \Jtgrimes\Advent\Day
{

    public $part1Solution = 'VPCDMSLWJ';
    public $part2Solution = 'TPWCGNCCG';
    public function part1()
    {
        $stacks = $this->populateStacks();
        $moves = $this->getMoveList();
        foreach ($moves as $move) {
            $stacks = $this->move($stacks, $move);
        }
        return $this->getTopCrates($stacks);
    }

    public function part2()
    {
        $stacks = $this->populateStacks();
        $moves = $this->getMoveList();
        foreach ($moves as $move) {
            $stacks = $this->fancyMove($stacks, $move);
        }
        return $this->getTopCrates($stacks);
    }

    private function populateStacks()
    {
        $lines = collect($this->getInputAsArrayOfLines());
        // find the first blank line:
        $blank = $lines->search(function ($item) {
            return empty(trim($item));
        });
        $stackInput = $lines->take($blank); // get a collection with just the stack data.
        // flip it, so the numbers are at the top, then the "bottom" row. Cause reasons.
        $stackInput = $stackInput->reverse();
        // we know that each crate is a single character, lined up below the number.
        // using regex instead of explode because 1-digit numbers have 2 leading spaces.
        $nums = $stackInput->shift();
        $nums = str_replace(PHP_EOL, '', $nums);
        $columns = preg_split("/[\s]+/",trim($nums));
        foreach ($columns as $column) {
            // this will tell us which column to look at for each stack.
            $positions[$column] = strpos($nums, "$column");
        }
        $stacks = [];
        $stackInput->each(function ($row) use ($positions, &$stacks){
            $chars = str_split($row);
            foreach ($positions as $col => $position) {
                if ($position < count($chars) && ! empty(trim($chars[$position]))) {
                    $stacks[$col][] = $chars[$position];
                }
            }
        });
        return $stacks;

    }

    private function getMoveList()
    {
        $lines = collect($this->getInputAsArrayOfLines());
        // find the first blank line:
        $blank = $lines->search(function ($item) {
            return empty(trim($item));
        });
        $moves = $lines->slice($blank+1); // throw out everything before the blank line
        return $moves->map(function ($line) {
            $parts = explode(' ', trim($line));
            return [
                'count' => $parts[1],
                'from' => $parts[3],
                'to' => $parts[5],
            ];
        });
    }

    private function move(array $stacks, array $move) : array
    {
        foreach (range(1, $move['count']) as $crate) {
            $stacks[$move['to']][] = array_pop($stacks[$move['from']]);
        }
        return $stacks;
    }

    private function getTopCrates(array $stacks)
    {
        $message = '';
        foreach ($stacks as $column) {
            $message .= array_pop($column);
        }
        return $message;
    }

    private function fancyMove(mixed $stacks, mixed $move)
    {
        // this is a cheap-ass way to do it, but ... it's where my brain is right now
        foreach (range(1, $move['count']) as $crate) {
            $temp[] = array_pop($stacks[$move['from']]);
        }

        foreach (range(1, $move['count']) as $crate) {
            $stacks[$move['to']][] = array_pop($temp);
        }

        return $stacks;
    }
}