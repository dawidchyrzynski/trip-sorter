<?php

namespace TripSorter;

class TripRepresentation
{
    private $boardingCards;

    public function __construct(array $boardingCards)
    {
        $this->boardingCards = $boardingCards;
    }

    public function generateList() : array
    {
        return [];
    }

    public function print() : void
    {
        $list = $this->generateList();

        // to do
    }
}
