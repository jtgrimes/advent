<?php

namespace Jtgrimes\Advent\y2015\Support;

use Illuminate\Support\Collection;

class Circuit
{
    protected $wires;

    public function __construct(Collection $input)
    {
        $this->wires = new Collection();
        $input->each(function ($line) {
            $parts = explode(' -> ', $line);
            $this->wires[trim($parts[1])] = trim($parts[0]);
        });
    }

    public function forceInput($wire, $value)
    {
        $this->wires[$wire] = $value;
    }

    public function resolve($wire)
    {
        if (is_null($wire)) {
            throw new \Exception("Wire is null");
        }
        $input = $this->wires[$wire];
        if (is_null($input)) {
            throw new \Exception("Input is null");
        }
        if (is_numeric($input)) {
            return (int)$input;
        }
        // this is a composite wire ... let's see what kind
        $parts = explode(' ', $input);
        if (count($parts) == 1) {
            // just a single input ... either a number or a wire
            if (is_numeric($parts[0])) {
                return (int)$parts[0];
            }
            return $this->resolve($parts[0]);
        }
        // possible ops: and, or, lshift, rshift, not
        if ($parts[0] == 'NOT') {
            if (is_numeric($parts[1])) {
                return ~ (int)$parts[1];
            }
            return ~ $this->resolve($parts[1]);
        }

        $first = is_numeric($parts[0]) ? (int)$parts[0] : $this->resolve($parts[0]);
        $second = is_numeric($parts[2]) ? (int)$parts[2] : $this->resolve($parts[2]);

        $result = match($parts[1]) {
            'AND' => $first & $second,
            'OR' => $first | $second,
            'LSHIFT' => $first << $second,
            'RSHIFT' => $first >> $second,
        };
        // let's cache this by replacing the value in the wire
        $this->wires[$wire] = $result;
        return $result;
    }
}