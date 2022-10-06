<?php

namespace Chess\Tests\Unit\Variant\Capablanca80;

use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Capablanca80\Board;

class BoardTest extends AbstractUnitTestCase
{
    /*
    |--------------------------------------------------------------------------
    | getPieces()
    |--------------------------------------------------------------------------
    |
    | Gets all pieces.
    |
    */

    /**
     * @test
     */
    public function get_pieces()
    {
        $board = new Board();

        $this->assertSame(40, count($board->getPieces()));
    }

    /*
    |--------------------------------------------------------------------------
    | play()
    |--------------------------------------------------------------------------
    |
    | Legal moves return true.
    |
    */

    /**
     * @test
     */
    public function start()
    {
        $board = new Board();

        $expected = [
            7 => [ ' r ', ' n ', ' a ', ' b ', ' q ', ' k ', ' b ', ' c ', ' n ', ' r ' ],
            6 => [ ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' A ', ' B ', ' Q ', ' K ', ' B ', ' C ', ' N ', ' R ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }

    /**
     * @test
     */
    public function play_Nj3_e5___Ci6_O_O()
    {
        $board = new Board();

        $board->play('w', 'Nj3');
        $board->play('b', 'e5');
        $board->play('w', 'Ci3');
        $board->play('b', 'Nc6');
        $board->play('w', 'h3');
        $board->play('b', 'b6');
        $board->play('w', 'Bh2');
        $board->play('b', 'Ci6');
        $board->play('w', 'O-O');

        $expected = [
            7 => [ ' r ', ' . ', ' a ', ' b ', ' q ', ' k ', ' b ', ' . ', ' n ', ' r ' ],
            6 => [ ' p ', ' . ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ', ' p ', ' p ' ],
            5 => [ ' . ', ' p ', ' n ', ' . ', ' . ', ' . ', ' . ', ' . ', ' c ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' P ', ' C ', ' N ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' P ', ' B ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' A ', ' B ', ' Q ', ' . ', ' . ', ' R ', ' K ', ' . ' ],
        ];

        $this->assertSame($expected, $board->toAsciiArray());
    }
}