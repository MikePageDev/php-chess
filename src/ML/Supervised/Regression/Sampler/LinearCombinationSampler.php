<?php

namespace Chess\ML\Supervised\Regression\Sampler;

use Chess\Board;
use Chess\Heuristic\Picture\LinearCombination as LinearCombinationHeuristicPicture;
use Chess\PGN\Symbol;

class LinearCombinationSampler extends AbstractSampler
{
    public function sample(): array
    {
        $heuristicPicture = (new LinearCombinationHeuristicPicture($this->board->getMovetext()))->take();

        $this->sample = [
            Symbol::WHITE => end($heuristicPicture[Symbol::WHITE]),
            Symbol::BLACK => end($heuristicPicture[Symbol::BLACK]),
        ];

        return $this->sample;
    }
}