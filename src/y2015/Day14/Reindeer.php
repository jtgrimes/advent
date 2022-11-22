<?php

namespace Jtgrimes\Advent\y2015\Day14;

class Reindeer
{
    public $position = 0;
    private $action;
    private $remaining;

    public function __construct(
        public string $name,
        protected int $speed,
        protected int $moveTurns,
        protected int $restTurns,
    ) {
        $this->action = 'moving';
        $this->remaining = $this->moveTurns;
    }

    public function turns(int $turns)
    {
        foreach(range(1,$turns) as $i) {
            $this->tick();
        }
    }

    public function tick()
    {
        if ($this->remaining == 0) {
            $this->toggleAction();
        }
        $this->performAction();
        $this->remaining--;
    }

    private function performAction()
    {
        if ($this->action == 'moving') {
            $this->position += $this->speed;
        }
    }

    private function toggleAction()
    {
        if ($this->action == 'moving') {
            $this->action = 'resting';
            $this->remaining = $this->restTurns;
        } else {
            $this->action = 'moving';
            $this->remaining = $this->moveTurns;
        }
    }

}