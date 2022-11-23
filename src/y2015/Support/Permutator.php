<?php

namespace Jtgrimes\Advent\y2015\Support;

class Permutator
{
    public function permutations(array $array)
    {
        if (count($array) < 1) {
            return [];
        }
        $result = [];
        foreach ($array as $i=>$item) {
            $copy = $array; // should copy instead of make a reference
            unset($copy[$i]);
            $inner = $this->permutations($copy);
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