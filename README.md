# Advent of Code
This repo contains every year's Advent of Code solutions in PHP (or at least as much of that year as I've done.) Don't forget to `composer install` before attempting to use it - I've taken advantage of packages other people have created because that's how programming works.

The code is run by calling `php advent.php [year] [day] [part]`, so to see the solution for part 2 of day 16, 2017 the command is `php advent.php 2017 16 2`.

Each day inherits from the base `Day` class which has utility methods for handling input. The result comes from echoing the return value for the `part1()` or `part2()` function.