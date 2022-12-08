<?php

namespace Jtgrimes\Advent\y2022;

use Illuminate\Support\Str;
use Jtgrimes\Advent\y2022\Day7\Directory;

class Day7 extends \Jtgrimes\Advent\Day
{

    public function part1()
    {
        $tree = $this->buildTree();
        $subdirectories = $tree->flatten();
        $matches = $subdirectories->filter(function ($size) {
            return $size <= 100000;
        });
        return $matches->sum();
    }

    public function part2()
    {
        $tree = $this->buildTree();
        $diskSize = 70000000;
        $goalFreeSpace = 30000000;
        $currentFree = $diskSize - $tree->size;
        $targetForDeletion = $goalFreeSpace - $currentFree;
        return $tree->flatten()->filter(function ($size) use ($targetForDeletion) {
            return $size > $targetForDeletion;
        })->min();
    }

    private function buildTree()
    {
        $startDirectory = Directory::first();
        $currentDirectory = $startDirectory;
        $lines = $this->getInputAsArrayOfLines();
        foreach ($lines as $line) {
            if (Str::startsWith($line, '$ cd ..')) {
                $currentDirectory = $currentDirectory->parent;
            } elseif (Str::startsWith($line, '$ cd')) {
                $name = Str::of($line)->trim()->match('/cd (.*)/');
                $currentDirectory = $currentDirectory->findChild($name);
            } elseif (Str::startsWith($line, '$ ls')) {
                // do nothing
            } else {
                // this is part of a directory listing ... add it.
                $currentDirectory->addChild($line);
            }
        }
        return $startDirectory;
    }
}