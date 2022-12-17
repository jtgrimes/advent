<?php

namespace Jtgrimes\Advent\y2019;

use mysql_xdevapi\Exception;

class Day2 extends \Jtgrimes\Advent\Day
{

    public $part1Solution = '3931283';
    public $part2Solution = '6979';
    public function part1()
    {
        return $this->getOutput(12,2);
    }

    public function part2()
    {
        foreach (range(0,99) as $noun) {
            foreach(range(0,99) as $verb) {
                $test = $this->getOutput($noun, $verb);
                if ($test == 19690720) {
                    break 2;
                }
            }
        }
        return 100 * $noun + $verb;
    }

    public function populateMemory()
    {
        return explode(',', trim($this->getInputAsString()));
    }

    public function getOutput($input1, $input2)
    {
        $registers = $this->populateMemory();
        $registers[1] = $input1;
        $registers[2] = $input2;
        for ($i = 0; $i < count($registers); $i += 4) {
            $opcode = (int)$registers[$i];
            if ($opcode == 99) {
                break;
            }
            $firstAddress = (int)$registers[$i + 1];
            $secondAddress = (int)$registers[$i + 2];
            $resultAddress = (int)$registers[$i + 3];
//            echo ("$opcode - $firstAddress ($registers[$firstAddress]), $secondAddress ($registers[$secondAddress]) => $resultAddress\n");
            switch ($opcode) {
                case 1:
                    $registers[$resultAddress] = (int)$registers[$firstAddress] + (int)$registers[$secondAddress];
                    break;
                case 2:
                    $registers[$resultAddress] = (int)$registers[$firstAddress] * (int)$registers[$secondAddress];
                    break;
                default:
                    throw new Exception("Unexpected OPCODE: $opcode");
            }
        }
        return $registers[0];
    }
}