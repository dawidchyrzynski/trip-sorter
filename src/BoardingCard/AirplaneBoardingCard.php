<?php

namespace TripSorter\BoardingCard;

class AirplaneBoardingCard extends BoardingCardBase implements BoardingCardInterface
{
    protected $requiredParams = ['flight', 'gate', 'seat'];

    public static function getTransportationName() : string
    {
        return 'airplane';
    }

    public function message() : string
    {
        $message = 'From %s, take flight %s to %s. Gate %s, seat %s. ';

        if ($this->hasParam('baggage')) {
            $message .= sprintf('Baggage drop at ticket counter %s.', $this->getParam('baggage'));
        } else {
            $message .= 'Baggage will we automatically transferred from your last leg.';
        }

        return sprintf(
            trim($message),
            $this->getDeparture(),
            $this->getParam('flight'),
            $this->getDestination(),
            $this->getParam('gate'),
            $this->getParam('seat')
        );
    }
}
