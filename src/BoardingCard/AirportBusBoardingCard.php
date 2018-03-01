<?php

namespace TripSorter\BoardingCard;

class AirportBusBoardingCard extends BoardingCardBase implements BoardingCardInterface
{
    protected $requiredParams = [];

    public static function getTransportationName() : string
    {
        return 'airport_bus';
    }

    public function message() : string
    {
        $message = 'Take the airport bus from %s to %s. ';

        if ($this->hasParam('seat')) {
            $message .= sprintf('Sit in seat %s.', $this->getParam('seat'));
        } else {
            $message .= 'No seat assignment.';
        }

        return sprintf(
            trim($message),
            $this->getDeparture(),
            $this->getDestination()
        );
    }
}
