<?php

namespace TripSorter;

class TripSorter
{
    public function analyzeBoardingCards(array $boardingCardsData) : TripRepresentation
    {
        $boardingCards = BoardingCardsProcessor::processCards($boardingCardsData);

        // logic goes here

        return new TripRepresentation($boardingCards);
    }
}
