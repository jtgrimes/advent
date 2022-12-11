<?php

namespace Jtgrimes\Advent\y2018;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
class Day4 extends \Jtgrimes\Advent\Day
{
    public $part1Solution = '38813';
    public $part2Solution = '141071';
    public function part1()
    {
        $events = $this->getEvents();
        $naps = $this->listNaps($events);
        $durations = $naps->groupBy('guard')->mapWithKeys(function ($naps, $guard) {
            return [$guard => $naps->pluck('duration')->sum()];
        })->sortDesc();
        $sleepyGuard = $durations->keys()->first();
        $minute = $this->findBestMinuteFor($sleepyGuard, $naps);
        return $sleepyGuard * $minute;
    }

    public function part2()
    {
        $events = $this->getEvents();
        $naps = $this->listNaps($events);
        $sleepers = [];
        $mostMinutes = 0;
        $bestGuard = 0;
        $bestMinute = 0;
        foreach ($naps as $nap) {
            $guard = $nap['guard'];
            $minutes = $this->napToArrayOfMinutes($nap);
            foreach ($minutes as $minute => $x) {
                if (array_key_exists($guard, $sleepers) && array_key_exists($minute, $sleepers[$guard])) {
                    $sleepers[$guard][$minute] += 1;
                } else {
                    $sleepers[$guard][$minute] = 1;
                }
                if ($sleepers[$guard][$minute] > $mostMinutes) {
                    $mostMinutes = $sleepers[$guard][$minute];
                    $bestGuard = $guard;
                    $bestMinute = $minute;
                }
            }
        }
        return $bestMinute * $bestGuard;
    }

    private function getEvents()
    {
        $events = $this->getInputAsCollectionOfLines()
            ->map(function ($line) {
                $matches = [];
                preg_match('/\[(.+?)\]/', $line, $matches);
                return [
                    'time' => $matches[1],
                    'action' => substr($line, strpos($line, ']') + 2),
                ];
            })->values()->sortBy('time');
        // have to get them sorted by time so we know which guard was where
        $activeGuard = '';
        return $events->map(function ($event) use (&$activeGuard) {
            $guard = [];
            preg_match('/Guard #(\d+)/', $event['action'], $guard);
            if (isset($guard[1])) {
                $activeGuard = $guard[1];
            }
            if (Str::contains($event['action'], 'falls')) {
                $action = 'sleep';
            }elseif (Str::contains($event['action'], 'wakes')) {
                $action = 'wake';
            } else {
                $action = 'start';
            }
            return [
                'time' => Carbon::parse($event['time']),
                'guard' => $activeGuard,
                'action' => $action,
            ];

        });
    }

    private function listNaps($events)
    {
        $naps = [];
        $napStart = Carbon::now();
        $events->each(function ($event) use (&$naps, &$napStart) {
            if ($event['action'] == 'sleep') {
                $napStart = $event['time'];
            } elseif ($event['action'] == 'wake') {
                $naps[] = [
                    'guard' => $event['guard'],
                    'start' => $napStart,
                    'end' => $event['time'],
                    'duration' => $napStart->diffInMinutes($event['time'])
                ];
            }
        });
        return collect($naps);
    }

    private function findBestMinuteFor($sleepyGuard, Collection $naps)
    {
        $naps = $naps->filter(function ($nap) use ($sleepyGuard){
            return $nap['guard'] == $sleepyGuard;
        })->map(function ($nap) {
            return $this->napToArrayOfMinutes($nap);
        });
        foreach (range(0,59) as $minute) {
            $nappingAt[$minute] = $naps->pluck($minute)->sum();
        }
        return array_search(max($nappingAt), $nappingAt);
    }

    private function napToArrayOfMinutes($nap)
    {
        if (! ($nap['start'])->isSameDay($nap['end'])) {
            $nap['start'] = $nap['start']->addDay(1)->startOfDay();
        }
        $startMinute = $nap['start']->minute;
        $endMinute = $nap['end']->minute;
        return collect(array_fill($startMinute, $endMinute - $startMinute, 1));
    }
}