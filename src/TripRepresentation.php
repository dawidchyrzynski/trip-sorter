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
        if (empty($this->boardingCards)) {
            return [];
        }

        $list = [];

        foreach ($this->boardingCards as $card) {
            $list[] = $card->message();
        }

        $list[] = 'You have arrived at your final destination.';

        return $list;
    }

    public function print() : void
    {
        $list = $this->generateList();

        if (empty($list)) {
            echo 'Opss! Something goes wrong.' , PHP_EOL;

            return;
        }

        foreach ($list as $i => $message) {
            echo ($i + 1) , '. ' , $message , PHP_EOL;
        }
    }
}
