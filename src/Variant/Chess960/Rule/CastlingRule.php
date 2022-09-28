<?php

namespace Chess\Variant\Chess960\Rule;

use Chess\Variant\Classical\PGN\AN\Castle;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\Rule\CastlingRule as ClassicalCastlingRule;

class CastlingRule extends ClassicalCastlingRule
{
    private array $startPos;

    private array $startFiles;

    public function __construct(array $startPos)
    {
        $this->startPos = $startPos;

        $this->startFiles = [
            'a' => $this->startPos[0],
            'b' => $this->startPos[1],
            'c' => $this->startPos[2],
            'd' => $this->startPos[3],
            'e' => $this->startPos[4],
            'f' => $this->startPos[5],
            'g' => $this->startPos[6],
            'h' => $this->startPos[7],
        ];

        $this->rule = (new ClassicalCastlingRule())->getRule();

        $this->sq()->sqs();
    }

    protected function sq()
    {
        $longCastlingRook = false;
        foreach ($this->startPos as $key => $val) {
            $wSq = chr(97+$key).'1';
            $bSq = chr(97+$key).'8';
            if ($val === Piece::R) {
                if (!$longCastlingRook) {
                    $this->rule[Color::W][Piece::R][Castle::LONG]['sq']['current'] = $wSq;
                    $this->rule[Color::B][Piece::R][Castle::LONG]['sq']['current'] = $bSq;
                    $longCastlingRook = true;
                } else {
                    $this->rule[Color::W][Piece::R][Castle::SHORT]['sq']['current'] = $wSq;
                    $this->rule[Color::B][Piece::R][Castle::SHORT]['sq']['current'] = $bSq;
                }
            } elseif ($val === Piece::K) {
                $this->rule[Color::W][Piece::K][Castle::LONG]['sq']['current'] = $wSq;
                $this->rule[Color::B][Piece::K][Castle::LONG]['sq']['current'] = $bSq;
                $this->rule[Color::W][Piece::K][Castle::SHORT]['sq']['current'] = $wSq;
                $this->rule[Color::B][Piece::K][Castle::SHORT]['sq']['current'] = $bSq;
            }
        }

        return $this;
    }

    protected function sqs()
    {
        $kPath = $this->path(
            $this->rule[Color::W][Piece::K][Castle::SHORT]['sq']['current'],
            $this->rule[Color::W][Piece::K][Castle::SHORT]['sq']['next']
        );


        $rPath = $this->path(
            $this->rule[Color::W][Piece::R][Castle::SHORT]['sq']['current'],
            $this->rule[Color::W][Piece::R][Castle::SHORT]['sq']['next']
        );

        $path = array_unique(array_merge($kPath, $rPath));
        sort($path);
        $this->rule[Color::W][Piece::K][Castle::SHORT]['sqs'] = $path;

        $kPath = $this->path(
            $this->rule[Color::W][Piece::K][Castle::LONG]['sq']['current'],
            $this->rule[Color::W][Piece::K][Castle::LONG]['sq']['next']
        );

        $rPath = $this->path(
            $this->rule[Color::W][Piece::R][Castle::LONG]['sq']['current'],
            $this->rule[Color::W][Piece::R][Castle::LONG]['sq']['next']
        );

        $path = array_unique(array_merge($kPath, $rPath));
        sort($path);
        $this->rule[Color::W][Piece::K][Castle::LONG]['sqs'] = $path;

        $kPath = $this->path(
            $this->rule[Color::B][Piece::K][Castle::SHORT]['sq']['current'],
            $this->rule[Color::B][Piece::K][Castle::SHORT]['sq']['next']
        );

        $rPath = $this->path(
            $this->rule[Color::B][Piece::R][Castle::SHORT]['sq']['current'],
            $this->rule[Color::B][Piece::R][Castle::SHORT]['sq']['next']
        );

        $path = array_unique(array_merge($kPath, $rPath));
        sort($path);
        $this->rule[Color::B][Piece::K][Castle::SHORT]['sqs'] = $path;

        $kPath = $this->path(
            $this->rule[Color::B][Piece::K][Castle::LONG]['sq']['current'],
            $this->rule[Color::B][Piece::K][Castle::LONG]['sq']['next']
        );

        $rPath = $this->path(
            $this->rule[Color::B][Piece::R][Castle::LONG]['sq']['current'],
            $this->rule[Color::B][Piece::R][Castle::LONG]['sq']['next']
        );

        $path = array_unique(array_merge($kPath, $rPath));
        sort($path);
        $this->rule[Color::B][Piece::K][Castle::LONG]['sqs'] = $path;
    }

    protected function path(string $from, string $to)
    {
        $path = [];
        $i = ord($from[0]);
        $j = ord($to[0]);
        $min = min($i, $j);
        $max = max($i, $j);
        for ($min; $min <= $max; $min++) {
            $file = chr($min);
            if (
                $this->startFiles[$file] !== Piece::R &&
                $this->startFiles[$file] !== Piece::K
            ) {
                $path[] = $file . $from[1];
            }
        }

        return $path;
    }
}