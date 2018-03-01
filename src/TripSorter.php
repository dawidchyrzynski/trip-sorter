<?php

namespace TripSorter;

class TripSorter
{
    public function analyzeBoardingCards(array $boardingCardsData) : TripRepresentation
    {
        return new TripRepresentation($boardingCardsData);
    }
}
