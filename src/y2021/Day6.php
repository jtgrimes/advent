<?php

namespace Jtgrimes\Advent\y2021;

class Day6 extends \Jtgrimes\Advent\Day
{

    public function part1()
    {
        $fish = $this->breedFish(80);
        return array_sum($fish);
    }

    public function part2()
    {
        $fish = $this->breedFish(256);
        return array_sum($fish);
    }

    private function breedFish($days)
    {
        $fish = explode(',', trim($this->getInputAsString()));
        echo ("Starting: ".count($fish)."\n");
        $fishAtDay = array_count_values($fish);
        echo ("Starting2: ".array_sum($fishAtDay)."\n");
        foreach (range(1,$days) as $days) {
            $newFishAtDay = array_fill(0, 9, 0);
            foreach ($fishAtDay as $day => $count) {
                if ($day == 0) {
                    $newFishAtDay[6] +=$count;
                    $newFishAtDay[8] +=$count;
                } else {
                    $newFishAtDay[$day - 1] += $count;
                }
                $fishAtDay = $newFishAtDay;
            }
        }
        return $fishAtDay;
    }
}