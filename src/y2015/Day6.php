<?php

namespace Jtgrimes\Advent\y2015;

use Jtgrimes\Advent\Day;

class Day6 extends Day
{
    public function part1()
    {
        $lights = $this->setUpLights();
        $lines = $this->getInputAsArrayOfLines();
        foreach ($lines as $line) {
            $input = $this->parseInput($line);
            $this->flipSwitches($input, $lights);
        }
        $total = 0;
        foreach ($lights as $row) {
            $total += array_sum($row);
        }
        return $total;
    }

    public function part2()
    {
        $lights = $this->setUpLights();
        $lines = $this->getInputAsArrayOfLines();
        foreach ($lines as $line) {
            $input = $this->parseInput($line);
            $this->setBrightness($input, $lights);
        }
        $total = 0;
        foreach ($lights as $row) {
            $total += array_sum($row);
        }
        return $total;
    }

    private function parseInput(string $line)
    {
        $input = [];
        $parts = explode(' ', $line);
        // we expect the format to be INSTRUCTION #, # "through" #,#
        $first = $parts[0];
        if ($first == 'toggle') {
            $input['action'] = 'toggle';
            $input['start'] = explode(',', $parts[1]);
            $input['end'] = explode(',', $parts[3]);
        } else { // string starts 'turn on' or 'turn off'
            $input['action'] = $parts[1];
            $input['start'] = explode(',', $parts[2]);
            $input['end'] = explode(',', $parts[4]);
        }

        return $input;
    }

    private function setUpLights()
    {
        // a 1000 element array prefilled with 1000 element array set to 0
        $zeros = array_fill(0,1000,0);
        return array_fill(0, 1000, $zeros);
    }

    private function flipSwitches(array $input, array &$lights)
    {
        for ($row = $input['start'][0]; $row <= $input['end'][0]; $row++) {
            for ($column = $input['start'][1]; $column <= $input['end'][1]; $column++) {
                switch($input['action']) {
                    case 'on':
                        $lights[$row][$column] = 1;
                        break;
                    case 'off':
                        $lights[$row][$column] = 0;
                        break;
                    case 'toggle':
                        $lights[$row][$column] = ! $lights[$row][$column];
                        break;
                    default:
                        throw new \Exception('invalid action: '.$input['action']);
                }
            }
        }
    }

    private function setBrightness(array $input, array &$lights)
    {
        for ($row = $input['start'][0]; $row <= $input['end'][0]; $row++) {
            for ($column = $input['start'][1]; $column <= $input['end'][1]; $column++) {
                switch($input['action']) {
                    case 'on':
                        $lights[$row][$column] += 1;
                        break;
                    case 'off':
                        $lights[$row][$column] -= 1;
                        if ($lights[$row][$column] <0) {
                            $lights[$row][$column] = 0;
                        }
                        break;
                    case 'toggle':
                        $lights[$row][$column] += 2;
                        break;
                    default:
                        throw new \Exception('invalid action: '.$input['action']);
                }
            }
        }
    }
}