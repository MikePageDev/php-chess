<?php

namespace Chess\Heuristic;

use Chess\AbstractPicture;
use Chess\PGN\Symbol;

class AdditionEvaluation implements HeuristicEvaluationInterface
{
    private $heuristicPicture;

    private $weigths;

    public function __construct(AbstractPicture $heuristicPicture)
    {
        $this->heuristicPicture = $heuristicPicture;

        $this->weights = [];
    }

    public function getWeights(): array
    {
        return $this->weigths;
    }

    public function evaluate(): array
    {
        $result = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $picture = $this->heuristicPicture->take();

        for ($i = 0; $i < count($this->heuristicPicture->getDimensions()); $i++) {
            $result[Symbol::WHITE] += end($picture[Symbol::WHITE])[$i];
            $result[Symbol::BLACK] += end($picture[Symbol::BLACK])[$i];
        }

        return $result;
    }
}