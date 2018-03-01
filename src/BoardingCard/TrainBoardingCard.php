<?php

namespace TripSorter\BoardingCard;

class TrainBoardingCard extends BoardingCardBase implements BoardingCardInterface
{
    protected $requiredParams = ['train'];

    public static function getTransportationName() : string
    {
        return 'train';
    }

    public function message() : string
    {
        $message = 'Take train %s from %s to %s. ';

        if ($this->hasParam('seat')) {
            $message .= sprintf('Sit in seat %s.', $this->getParam('seat'));
        } else {
            $message .= 'No seat assignment.';
        }

        return sprintf(
            trim($message),
            $this->getParam('train'),
            $this->getDeparture(),
            $this->getDestination()
        );
    }
}
