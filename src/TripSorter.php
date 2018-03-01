<?php

namespace TripSorter;

use TripSorter\BoardingCard\BoardingCardInterface;

class TripSorter
{
    /**
     * Analyzes given list of boarding cards and generates representation which may be
     * printed.
     *
     * Input data needs to be in the specific format:
     * 1. Input data must be an array containing boarding cards. Each boarding card must be a separated item.
     * 2. Each boarding card should have at least 3 fields defined:
     *    - departure: name of the departure point.
     *    - destination: name of the destination point.
     *    - transportation: name of the transportation method (airplane, airport_bus, train).
     * 3. All other fields depends on the transportation type:
     *    - airplane: must have `flight`, `gate` and `seat`. The `baggage` field is optional.
     *    - airport_bus: nothing additional required. You may provide `seat` number which will change the message.
     *    - train: must have `train`. The `seat` field is optional.
     *
     * Example:
     * [
     *    [
     *        'departure' => 'Madrid',
     *        'destination' => 'Barcelona',
     *        'transportation' => 'train',
     *        'train' => '78A',
     *        'seat' => '45B'
     *    ],
     *    [
     *        'departure' => 'Barcelona',
     *        'destination' => 'Gerona Airport',
     *        'transportation' => 'airport_bus',
     *        'seat' => null
     *    ],
     *    ...
     * ]
     *
     * @param array $boardingCardsData The list of boarding cards in the format described above.
     * @return TripRepresentation Representation of the trip. See \TripSorter\TripRepresentation.
     */
    public function analyzeBoardingCards(array $boardingCardsData) : TripRepresentation
    {
        $boardingCards = BoardingCardsProcessor::processCards($boardingCardsData);

        // the main logic
        if (count($boardingCards) > 1) {
            $boardingCards = $this->sortBoardingCards($boardingCards);
        }

        return new TripRepresentation($boardingCards);
    }

    private function sortBoardingCards(array $boardingCards) : array
    {
        $lookupTable = $this->createLookupTable($boardingCards);
        $startingPoint = $this->findStartingPoint($lookupTable);
        $output = $this->traverseLinkedList($startingPoint, $lookupTable);

        // check whether chain is not broken
        if (count($output) != count($boardingCards)) {
            throw new \Exception('Broken boarding cards chain');
        }

        return $output;
    }

    private function createLookupTable(array $boardingCards) : array
    {
        $lookupTable = [];

        foreach ($boardingCards as $card) {
            $dep = $card->getDeparture();
            $dest = $card->getDestination();

            if (!array_key_exists($dep, $lookupTable)) {
                $lookupTable[$dep] = [
                    'departure_card' => null,
                    'destination_card' => $card
                ];
            } else {
                if (!empty($lookupTable[$dep]['destination_card'])) {
                    throw new \Exception('Circular boarding cards');
                } else {
                    $lookupTable[$dep]['destination_card'] = $card;
                }
            }

            if (!array_key_exists($dest, $lookupTable)) {
                $lookupTable[$dest] = [
                    'departure_card' => $card,
                    'destination_card' => null
                ];
            } else {
                if (!empty($lookupTable[$dest]['departure_card'])) {
                    throw new \Exception('Circular boarding cards');
                } else {
                    $lookupTable[$dest]['departure_card'] = $card;
                }
            }
        }

        return $lookupTable;
    }

    private function findStartingPoint(array $lookupTable) : array
    {
        foreach ($lookupTable as $key => $entry) {
            if (!$entry['departure_card']) {
                return $entry;
            }
        }

        throw new \Exception('Cannot find starting point of the trip.');
    }

    private function traverseLinkedList(array $point, array $lookupTable) : array
    {
        $output = [];

        while (!is_null($point['destination_card'])) {
            $card = $point['destination_card'];

            $output[] = $card;

            $point = $lookupTable[$card->getDestination()];
        }

        return $output;
    }
}
