<?php

namespace Jtgrimes\Advent\y2017;

use Illuminate\Support\Str;

class Day7 extends \Jtgrimes\Advent\Day
{
    private $foundUnbalanced = false;
    private $unbalanced = '';

    public $part1Solution = 'cyrupz';
    public $part2Solution = '193';
    public function part1()
    {
        $programs = $this->buildProgramTree();
        return $this->findBase($programs);
    }

    public function part2()
    {
        $programs = $this->buildProgramTree();
        $base = $this->findBase($programs);
        $programs = $this->findUnbalanced($base, $programs);
        $this->dumpChildInfo($this->unbalanced, $programs);
        // kinda brute forced it from here.
        $this->dumpChildInfo('cwwwj', $programs);
    }

    private function buildProgramTree()
    {
        $nodes = $this->getInputAsCollectionOfLines()
            ->mapWithKeys(function ($program) {
                $id = Str::before($program, ' ');
                $weight = Str::between($program, '(', ')');
                $children = Str::contains($program, '->')
                    ? explode(', ', trim(Str::after($program, '-> ')))
                    : [];
                return [$id => ['weight' => $weight, 'children' => $children]];
            });
        $nodes->each(function ($node, $id) use ($nodes) {
            foreach ($node['children'] as $childName) {
                $child = $nodes->get($childName);
                $child['parent'] = $id;
                $nodes[$childName] = $child;
            }
        });
        return $nodes;
    }

    private function findBase($programs)
    {
        $id = $programs->keys()->first();
        $done = false;
        while (! $done) {
            $node = $programs->get($id);
            if (array_key_exists('parent', $node)) {
                $id = $node['parent'];
            } else {
                $done = true;
            }
        }
        return $id;
    }

    private function findUnbalanced($id, $programs)
    {
        $node = $programs->get($id);
        if (empty($node['children'])) {
            $node['fweight'] = $node['weight'];
            $programs[$id] = $node;
        } else {
            $fweight = $node['weight'];
            foreach ($node['children'] as $child) {
                $this->findUnbalanced($child, $programs);
                $childWeight[] = $programs->get($child)['fweight'];
            }
            if (1 == count(array_count_values($childWeight))) {
            } else {
                if (! $this->foundUnbalanced) {
                    $this->foundUnbalanced = true;
                    $this->unbalanced = $id;
                }
            }
            $node['fweight'] = $fweight + array_sum($childWeight);
            $programs[$id] = $node;
        }
        return $programs;

    }

    private function dumpChildInfo($id, $programs)
    {
        $node = $programs->get($id);
        echo "node $id    weight {$node['weight']}    fweight {$node['fweight']}\n";
        echo "children:\n";
        foreach ($programs->get($id)['children'] as $child) {
            echo "$child: ".$programs->get($child)['fweight']."\n";
        }

    }
}