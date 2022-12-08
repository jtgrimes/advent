<?php

namespace Jtgrimes\Advent\y2022\Day7;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Directory
{
    public Directory $parent;
    private Collection $directories;
    private Collection $files;
    public string $name;
    public int $size = 0;

    private function __construct(string $name)
    {
        $this->name = $name;
        $this->directories = collect([]);
        $this->files = collect([]);
    }

    public static function first()
    {
        return new static('/');
    }

    public function createChild(string $name)
    {
        $child = new Directory($name);
        $child->parent = $this;
        $this->directories->add(($child));
    }

    public function findChild(string $name)
    {
        return $this->directories->firstWhere('name', $name);
    }

    public function addChild(string $input)
    {
        if (Str::startsWith($input, 'dir ')) {
            $this->createChild(Str::replaceFirst('dir ','', trim($input)));
        } else {
            // must be a file - should be `bytes name`
            list($bytes, $name) = explode(' ', trim($input));
            $this->files[$name] = (int)$bytes;
            $this->size += (int)$bytes;
            $this->increaseParentSize((int)$bytes);
        }
    }

    private function increaseParentSize(int $bytes)
    {
        if (isset($this->parent)) {
            $this->parent->size += $bytes;
            $this->parent->increaseParentSize($bytes);
        }
    }

    private function getPath()
    {
        if (isset($this->parent)) {
            return $this->parent->getPath().'.'.$this->name;
        }
        return $this->name;
    }

    public function flatten()
    {
        $subdirectories = collect([]);
        $this->directories->each(function ($dir) use (&$subdirectories) {
            $subdirectories = $subdirectories->merge($dir->flatten());
        });


        return collect([$this->getPath() => $this->size])
            ->merge($this->directories->mapWithKeys(function ($dir) {
                return [$dir->getPath() => $dir->size];
            })->merge($subdirectories)
        );
    }

}