<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;

if (isset($argc)) {
    if ($argv[1] == 'todo') {
        todo();
    } elseif ($argv[1] == 'all') {
        all();
    } elseif ($argv[1] == 'test') {
        test();
    } else {
        $year = $argv[1];
        $day = $argv[2];
        $part = $argv[3] ?? '1';

        echo "Year: $year, Day: $day, Part: $part".PHP_EOL;
        echo (run($year, $day, $part).PHP_EOL);
    }
} else {
    echo "invalid args\n";
}

function className($year, $day)
{
    return 'Jtgrimes\Advent\y'.$year.'\Day'.$day;
}
function run($year, $day, $part)
{
    $class = new (className($year, $day));
    return ($part == 1 ? $class->part1() : $class->part2());
}

function todo()
{
    foreach (range(2015, \Carbon\Carbon::now()->year) as $year) {
        foreach (range(1,25) as $day) {
            if (! class_exists("Jtgrimes\\Advent\\y$year\\Day$day")) {
                echo "$year: day $day\n";
                break;
            }
        }
    }
}

function all()
{
    foreach (range(2015, \Carbon\Carbon::now()->year) as $year) {
        foreach (range(1,25) as $day) {
            $className = className($year, $day);
            if (class_exists($className)) {
                $result1 = run($year, $day, 1);
                echo "Year: $year:  Day: $day  Part: 1     RESULT: $result1\n";
                $result2 = run($year, $day, 2);
                echo "Year: $year:  Day: $day  Part: 2     RESULT: $result2\n";
            }
        }
    }
}

function test()
{
    foreach (range(2015, \Carbon\Carbon::now()->year) as $year) {
        foreach (range(1,25) as $day) {
            $className = className($year, $day);
            if (class_exists($className)) {
                $instance = new ($className);
                if ($instance->part1Solution) {
                    $result1 = run($year, $day, 1);
                    if ($instance->part1Solution != $result1) {
                        echo "Year: $year:  Day: $day  Part: 1     RESULT: $result1     EXPECTED {$instance->part1Solution}\n";
                    }
                } else {
                    echo "Year: $year:  Day: $day  Part 1 solution not provided\n";
                }
                if ($instance->part2Solution) {
                    $result2 = run($year, $day, 2);
                    if ($instance->part2Solution != $result2) {
                        echo "Year: $year:  Day: $day  Part: 2     RESULT: $result2     EXPECTED {$instance->part2Solution}\n";
                    }
                } else {
                    echo "Year: $year:  Day: $day  Part 2 solution not provided\n";
                }
            }
        }
    }
}