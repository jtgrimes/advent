<?php

namespace Jtgrimes\Advent\y2015\Support;

class Combinator
{
    public function __construct(protected array $array) {}

    public function permutations($choose = 0)
    {
        if ($choose == 0) {
            $choose = count($this->array);
        }
        return $this->calculatePermutations($this->array, $choose);
    }

    public function combinations($choose)
    {
        return $this->calculateCombinations($choose);
    }

    private function calculatePermutations(array $array, $count)
    {
        if (count($array) < 1 || $count == 0) {
            return [];
        }
        $result = [];
        foreach ($array as $i=>$item) {
            $copy = $array; // should copy instead of make a reference
            unset($copy[$i]);
            $inner = $this->calculatePermutations($copy, $count-1);
            if (empty($inner)) {
                $result[] = [$item];
            }
            foreach ($inner as $list) {
                $result[] = array_merge([$item], $list);
            }
        }
        return $result;
    }


    private function calculateCombinations(int $count)
    {
        if ($count == 0) {
            return [];
        }
        $result = [];
        foreach ($this->array as $i=>$item) {
            $inner = $this->calculateCombinations($count-1);
            if (empty($inner)) {
                $result[] = [$item];
            }
            foreach ($inner as $list) {
                $result[] = array_merge([$item], $list);
            }
        }
        return $result;
    }

}