<?php

namespace TripSorter;

class TripRepresentation
{
    private $boardingCards;

    public function __construct(array $boardingCards)
    {
        $this->boardingCards = $boardingCards;
    }

    /**
     * Generates list of the messages generated based on the boarding cards processed by the algorithm.
     * Each item in the array is an ready-to-display string describing the trip step.
     *
     * @return array Array of the boarding cards ordered from starting point to the last point of the trip.
     */
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

    /**
     * Obtains the messages list using TripRepresentation::generateList()
     * and prints all messages.
     */
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
