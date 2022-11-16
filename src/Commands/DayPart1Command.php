<?php

namespace Jtgrimes\Advent\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DayPart1Command extends Command
{
    protected static $defaultDescription = 'Runs Day 1, part 1';
    protected static $defaultName = 'part1';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('running part 1');
        return Command::SUCCESS;
    }
}