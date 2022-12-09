<?php

namespace Jtgrimes\Advent\y2021;

use Exception;
use Illuminate\Support\Str;

class Day3 extends \Jtgrimes\Advent\Day
{

    public function part1()
    {
        $readings = $this->getInputAsCollectionOfLines()->map(function ($item) { return trim($item);});
        return $this->getPowerConsumption($readings);
     }

    public function part2()
    {
        $readings = $this->getInputAsCollectionOfLines()->map(function ($item) { return trim($item);});
        // since we're updating $readings in the function, call the fn with a copy.
        $generator = $this->getCollectionRating(collect($readings->toArray()), true);
        $scrubber = $this->getCollectionRating($readings, false);
        return $generator * $scrubber;
    }

    private function getPowerConsumption(\Illuminate\Support\Collection $readings)
    {
        $gamma = '';
        $epsilon = '';
        $len = strlen(trim($readings[0]));
        foreach (range(0, $len - 1) as $position) {
            $count = $readings->reduce(function ($carry, $reading) use ($position) {
                return $carry + (int)(str_split($reading))[$position];
            });
            $gamma .= (int)($count > $readings->count() / 2);
            $epsilon .= (int)(! $gamma[$position]);
        }
        return $this->bin2dec($gamma) * $this->bin2dec($epsilon);
    }

    private function getCollectionRating(\Illuminate\Support\Collection $readings, $isGenerator)
    {
        $len = strlen(trim($readings[0]));
        foreach (range(0, $len - 1) as $position) {
            $count = $readings->reduce(function ($carry, $reading) use ($position) {
                return $carry + (int)(str_split($reading))[$position];
            });
            $tied = ($count == $readings->count() / 2);
            $moreFrequent = ($count > $readings->count() / 2) ? 1 : 0;
            if ($isGenerator) {
                // keep the more frequent values, if equal, keep 1s
                $keep = $tied ? 1 : $moreFrequent;
            } else {
                // keep the more frequent values, if equal, keep 1s
                $keep = $tied ? 0 : (1-$moreFrequent);
            }
            $readings = $readings->filter(function ($reading) use ($position, $keep) {
                return (int)(str_split($reading))[$position] == $keep;
            });
            if ($readings->count() == 1) {
                // stop if there's only one left
                break;
            }
        }
        return $this->bin2dec($readings->first());
    }

    private function bin2dec(string $bin)
    {
        $total = 0;
        $reversed = Str::reverse($bin);
        $chars = str_split($reversed);
        foreach ($chars as $i => $char) {
            $total += (int)$char * (2 ** $i);
        }
        return $total;
    }
}
