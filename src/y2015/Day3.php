<?php

namespace Jtgrimes\Advent\y2015;

use Jtgrimes\Advent\Day;

class Day3 extends Day
{
    public function part1()
    {
        $moves = $this->getInputAsArrayOfCharacters();
        $x = 0;
        $y = 0;
        $gifts[$x][$y] = 'visited';
        foreach ($moves as $move) {
            if ($move =='^') {
                $x +=1;
            }
            if ($move =='v') {
                $x -=1;
            }
            if ($move =='>') {
                $y +=1;
            }
            if ($move =='<') {
                $y -=1;
            }

            $gifts[$x][$y] = 'visited';
        }
        $houses = 0;
        foreach ($gifts as $eastWestArray) {
            $houses += count($eastWestArray);
        }
        return $houses;
    }

    public function part2()
    {
        $moves = $this->getInputAsArrayOfCharacters();
        $santa = true;
        $SantaX = 0;
        $SantaY = 0;
        $RobotX = 0;
        $RobotY = 0;
        $gifts[$SantaX][$SantaY] = 'visited';
        foreach ($moves as $move) {
            $santa = ! $santa;
            if ($santa) {
                $xVar = 'SantaX';
                $yVar = 'SantaY';
            } else {
                $xVar = 'RobotX';
                $yVar = 'RobotY';
            }

            if ($move =='^') {
                $$xVar +=1;
            }
            if ($move =='v') {
                $$xVar -=1;
            }
            if ($move =='>') {
                $$yVar +=1;
            }
            if ($move =='<') {
                $$yVar -=1;
            }

            $gifts[$$xVar][$$yVar] = 'visited';
        }
        $houses = 0;
        foreach ($gifts as $eastWestArray) {
            $houses += count($eastWestArray);
        }
        return $houses;
    }
}