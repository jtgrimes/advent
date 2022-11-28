<?php

namespace Jtgrimes\Advent\y2015;

use Jtgrimes\Advent\Day;
use Jtgrimes\Advent\y2015\Support\AuntSue;
use Jtgrimes\Advent\y2015\Support\Combinator;

class Day15 extends Day
{
    public function part1()
    {
        // tried doing combinatorics & ran out of memory. This way, we only have to keep one combination in memory at a time
        $ingredients = $this->getIngredients();
        $maxScore = 0;
        // only 4 ingredients - we're gonna brute force it.
        for ($sprinkles = 0; $sprinkles < 100; $sprinkles ++) {
            for ($pb = 0; $pb < (100 - $sprinkles); $pb++) {
                for ($frosting = 0; $frosting < (100 - $sprinkles - $pb); $frosting++) {
                    $score = $this->calculateScore($ingredients, $sprinkles, $pb, $frosting, 100 - $sprinkles - $pb - $frosting);
                    if ($score > $maxScore) {
                        $maxScore = $score;
                    }
                }
            }
        }
        return $maxScore;
    }

    public function part2()
    {
        $ingredients = $this->getIngredients();
        $maxScore = 0;
        // only 4 ingredients - we're gonna brute force it.
        for ($sprinkles = 0; $sprinkles < 100; $sprinkles ++) {
            for ($pb = 0; $pb < (100 - $sprinkles); $pb++) {
                for ($frosting = 0; $frosting < (100 - $sprinkles - $pb); $frosting++) {
                    $score = $this->calculateScore($ingredients, $sprinkles, $pb, $frosting, 100 - $sprinkles - $pb - $frosting, true);
                    if ($score > $maxScore) {
                        $maxScore = $score;
                    }
                }
            }
        }
        return $maxScore;
    }

    private function getIngredients()
    {
        $ingredients = [];
        $lines = $this->getInputAsArrayOfLines();
        foreach ($lines as $line) {
            $parts = explode(':', $line);
            $ingredient = $parts[0];
            $properties = explode(',', $parts[1]);
            foreach ($properties as $property) {
                $values = explode(' ', trim($property));
                $property = $values[0];
                $value = $values[1];
                $ingredients[$ingredient][$property] = $value;
            }
        }
        return $ingredients;
    }

    private function calculateScore(array $ingredients, int $sprinkles, int $pb, int $frosting, int $sugar, bool $limitCalories = false)
    {
        foreach (['capacity', 'durability', 'flavor', 'texture', 'calories'] as $property) {
            $$property = $sprinkles * $ingredients['Sprinkles'][$property]
                + $pb * $ingredients['PeanutButter'][$property]
                + $frosting * $ingredients['Frosting'][$property]
                + $sugar * $ingredients['Sugar'][$property];
        }
        if ($limitCalories && $calories != 500) {
            return 0;
        }
        if ($capacity < 0 || $durability < 0 || $flavor < 0 || $texture < 0) {
            return 0;
        }
        return $capacity * $durability * $flavor * $texture;
    }
}