<?php

namespace Jtgrimes\Advent\y2017;

class Day8 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = '5849';
    public $part2Solution = '6702';
    public function part1()
    {
        $instrux = $this->getInstructions();
        $registers = $instrux->mapWithKeys(function ($instruction) {
            return [$instruction['register'] => 0];
        });
        $instrux->each (function ($instruction) use (&$registers) {
            if ($this->checkCondition($instruction['condition'], $registers)) {
                $registers[$instruction['register']] += $instruction['increment'];
            }
        });
        return max($registers->toArray());
    }

    public function part2()
    {
        $max = 0;
        $instrux = $this->getInstructions();
        $registers = $instrux->mapWithKeys(function ($instruction) {
            return [$instruction['register'] => 0];
        });
        $instrux->each (function ($instruction) use (&$registers, &$max) {
            if ($this->checkCondition($instruction['condition'], $registers)) {
                $registers[$instruction['register']] += $instruction['increment'];
                if ($registers[$instruction['register']] > $max) {
                    $max = $registers[$instruction['register']];
                }
            }
        });
        return $max;
    }

    private function checkCondition(string $condition, $registers)
    {
        list($register, $operation, $amount) = explode(' ', $condition);
        switch ($operation) {
            case '<':
                return $registers[$register] < (int)$amount;
            case '<=':
                return $registers[$register] <= (int)$amount;
            case '>':
                return $registers[$register] > (int)$amount;
            case '>=':
                return $registers[$register] >= (int)$amount;
            case '==':
                return $registers[$register] == (int)$amount;
            case '!=':
                return $registers[$register] != (int)$amount;
            default:
                throw new \Exception("Unexpected operation $operation");
        }
    }

    public function getInstructions()
    {
        return $this->getInputAsCollectionOfLines()->map(function ($instruction) {
            list ($action, $condition) = explode(' if ', $instruction);
            list ($register, $operation, $amount) = explode(' ', $action);
            return [
                'register' => $register,
                'increment' => (int)$amount * ($operation == 'inc' ? 1 : -1),
                'condition' => $condition,
            ];
        });
    }
}