<?php

namespace Chess\Movetext;

use Chess\Variant\Classical\PGN\Move;
use Chess\Variant\Classical\PGN\AN\Termination;

/**
 * Recursive Annotation Variation.
 *
 * @license GPL
 */
class RavMovetext extends AbstractMovetext
{
    /**
     * SAN movetext.
     *
     * @var \Chess\Movetext\SanMovetext
     */
    private SanMovetext $san;

    /**
     * Constructor.
     *
     * @param \Chess\Variant\Classical\PGN\Move $move
     * @param string $movetext
     */
    public function __construct(Move $move, string $movetext)
    {
        parent::__construct($move, $movetext);

        $this->san = new SanMovetext($move, $movetext);
    }

    /**
     * Before inserting elements into the array of moves.
     *
     * @return \Chess\Movetext\RavMovetext
     */
    protected function beforeInsert(): RavMovetext
    {
        // remove comments
        $movetext = preg_replace("/\{[^)]+\}/", '', $this->filter());
        // remove parentheses
        $movetext = preg_replace("/\(/", '', $movetext);
        $movetext = preg_replace("/\)/", '', $movetext);
        // replace multiple spaces with a single space
        $movetext = preg_replace('/\s+/', ' ', $movetext);

        $this->validation = trim($movetext);

        return $this;
    }

    /**
     * Insert elements into the array of moves.
     *
     * @see \Chess\Play\RavPlay
     */
    protected function insert(): void
    {
        foreach (explode(' ', $this->validation) as $key => $val) {
            if (preg_match('/^[1-9][0-9]*\.\.\.(.*)$/', $val)) {
                $exploded = explode(Move::ELLIPSIS, $val);
                $this->moves[] = $exploded[1];
            } elseif (preg_match('/^[1-9][0-9]*\.(.*)$/', $val)) {
                $this->moves[] = explode('.', $val)[1];
            } else {
                $this->moves[] = $val;
            }
        }

        $this->moves = array_values(array_filter($this->moves));
    }

    /**
     * Syntactically validated movetext.
     *
     * @throws \Chess\Exception\UnknownNotationException
     * @return string
     */
    public function validate(): string
    {
        foreach ($this->moves as $move) {
            $this->move->validate($move);
        }

        return $this->validation;
    }

    /**
     * Filtered movetext.
     *
     * @return string
     */
    public function filter(): string
    {
        // remove PGN symbols
        $movetext = str_replace(Termination::values(), '', $this->movetext);
        // replace FIDE notation with PGN notation
        $movetext = str_replace('0-0', 'O-O', $movetext);
        $movetext = str_replace('0-0-0', 'O-O-O', $movetext);
        // replace multiple spaces with a single space
        $movetext = preg_replace('/\s+/', ' ', $movetext);
        // remove space between dots
        $movetext = preg_replace('/\s\./', '.', $movetext);
        // remove space after dots
        $movetext = preg_replace('/\.\s/', '.', $movetext);

        return trim($movetext);
    }

    /**
     * Returns the main variation.
     *
     * @return string
     */
    public function main(): string
    {
        $movetext = $this->san->validate();
        // remove ellipsis
        $movetext = preg_replace('/[1-9][0-9]*\.\.\./', '', $movetext);

        return $movetext;
    }
}