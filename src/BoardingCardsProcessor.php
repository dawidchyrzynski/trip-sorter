<?php

namespace TripSorter;

use TripSorter\BoardingCard\BoardingCardInterface;

class BoardingCardsProcessor
{
    public static function processCards(array $boardingCards) : array
    {
        return array_map(
            '\TripSorter\BoardingCardsProcessor::processSingleCard',
            $boardingCards
        );
    }

    private static function processSingleCard(array $card) : BoardingCardInterface
    {
        self::validateCard($card);

        $transportationName = mb_strtolower($card['transportation']);
        $cardModel = BoardingCardFactory::get()->createByTransportationName($transportationName);

        $cardModel->setDeparture($card['departure']);
        $cardModel->setDestination($card['destination']);

        // all other fields will become "params"
        unset($card['transportation'], $card['departure'], $card['destination']);

        $cardModel->setParams($card);

        if (!$cardModel->hasAllRequiredParams()) {
            throw new \InvalidArgumentException('One of the board card does not have all required parameters.');
        }

        return $cardModel;
    }

    private static function validateCard(array $card) : void
    {
        if (!isset($card['departure'])) {
            throw new \InvalidArgumentException('Departure must be set for the boarding card.');
        }

        if (!isset($card['destination'])) {
            throw new \InvalidArgumentException('Destination must be set for the boarding card.');
        }

        if (!isset($card['transportation'])) {
            throw new \InvalidArgumentException('Transportation must be set for boarding card.');
        }
    }
}
