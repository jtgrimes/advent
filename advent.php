<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;



if (isset($argc)) {
    $year = $argv[1];
    $day = $argv[2];
    $part = $argv[3] ?? '1';

    echo "Year: $year, Day: $day, Part: $part".PHP_EOL;
    $class = new ('Jtgrimes\Advent\y'.$year.'\Day'.$day);

    echo ($part == 1 ? $class->part1() : $class->part2());
} else {
    echo "invalid args\n";
}

