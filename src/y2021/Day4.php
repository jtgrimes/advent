<?php

namespace Jtgrimes\Advent\y2021;

use Jtgrimes\Advent\y2021\Support\BingoBoard;

class Day4 extends \Jtgrimes\Advent\Day
{

    // pulled out of the input file so that we can parse it into boards more easily
    protected $draws = [46,79,77,45,57,34,44,13,32,88,86,82,91,97,89,1,48,31,18,10,55,74,24,11,80,78,28,37,47,17,21,61,26,85,99,96,23,70,3,54,5,41,50,63,14,64,42,36,95,52,76,68,29,9,98,35,84,83,71,49,73,58,56,66,92,30,51,20,81,69,65,15,6,16,39,43,67,7,59,40,60,4,90,72,22,0,93,94,38,53,87,27,12,2,25,19,8,62,33,75];

    public function part1()
    {
        $boards = $this->createBoardsFromInput();
        foreach ($this->draws as $draw) {
            $this->markBoards($boards, $draw);
            $winner = $this->findWinner($boards);
            if ($winner) {
                echo ("Board found on draw $draw\n");
                print_r($winner);
                return $this->computeScore($winner) * $draw;
            }
        }
    }

    public function part2()
    {
        $boards = $this->createBoardsFromInput();
        foreach ($this->draws as $draw) {
            $this->markBoards($boards, $draw);
            $this->dropWinners($boards);
            if (count($boards) == 1) {
                break;
            }
        }
        $lastBoard = [array_shift($boards)]; // array with just the one board in it
        foreach ($this->draws as $draw) {
            $this->markBoards($lastBoard, $draw);
            $winner = $this->findWinner($lastBoard);
            if ($winner) {
                echo ("Board found on draw $draw\n");
                print_r($winner);
                return $this->computeScore($winner) * $draw;
            }

        }
    }

    private function createBoardsFromInput()
    {
        $boards = [];
        $lines = $this->getInputAsArrayOfLines();
        $fileSize = count($lines);
        for ($i = 0; $i < $fileSize; $i += 6) { // 5 rows and a blank one
            $board = [];
            for ($row = 0; $row < 5; $row++) {
                // using regex instead of explode because 1-digit numbers have 2 leading spaces.
                $board[$row] = preg_split("/[\s]+/",trim($lines[$i + $row]));
            }
            $boards[] = $board;
        }
        return $boards;
    }

    private function markBoards(array &$boards, mixed $draw)
    {
        foreach ($boards as $b=> $board) {
            foreach ($board as $r => $row) {
                foreach ($row as $s => $square) {
                    if ((int)$square == $draw) {
                        $boards[$b][$r][$s] = 'X';
                        break;
                    }
                }
            }
        }
    }

    private function findWinner(array $boards)
    {
        foreach ($boards as $b=>$board) {
            if ($this->isWinner($board)) {
                return $board;
            }
        }
    }

    private function isWinner($board)
    {
        if (is_null($board)) {
            return false;
        }
        foreach ($board as $r=> $row) {
            if (   $board[$r][0] == 'X'
                && $board[$r][1] == 'X'
                && $board[$r][2] == 'X'
                && $board[$r][3] == 'X'
                && $board[$r][4] == 'X') {
                return true;
            }
        }
        // no match in rows, now we search columns
        foreach (range(0,4) as $column) {
            if ($board[0][$column] == 'X'
                && $board[1][$column] == 'X'
                && $board[2][$column] == 'X'
                && $board[3][$column] == 'X'
                && $board[4][$column] == 'X') {
                return true;
            }
        }
        return false;
    }

    private function computeScore(array $winner)
    {
        $score = 0;
        foreach ($winner as $row) {
            foreach ($row as $square) {
                if (is_numeric($square)) {
                    $score += (int)$square;
                }
            }
        }
        return $score;
    }

    private function dropWinners(array &$boards)
    {
        foreach ($boards as $b=>$board) {
            if ($this->isWinner($board)) {
                unset($boards[$b]);
            }
        }
    }
}