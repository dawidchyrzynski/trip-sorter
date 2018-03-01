<?php

namespace TripSorter\BoardingCard;

interface BoardingCardInterface
{
    /**
     * Should return lowercase name of the transportation.
     */
    public static function getTransportationName() : string;

    /**
     * Should return message based on the model's parameters.
     */
    public function message() : string;
}
