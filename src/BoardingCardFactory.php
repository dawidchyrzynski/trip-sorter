<?php

namespace TripSorter;

use TripSorter\BoardingCard\BoardingCardInterface;

class BoardingCardFactory
{
    private static $instance;
    private $boardingCardsClasses = [];

    public function createByTransportationName(string $name) : BoardingCardInterface
    {
        if (!array_key_exists($name, $this->boardingCardsClasses)) {
            throw new \Exception('Unknown transportation name: ' . $name);
        }

        $className = $this->boardingCardsClasses[$name];

        return new $className();
    }

    public static function get() : BoardingCardFactory
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->register('TripSorter\BoardingCard\AirplaneBoardingCard');
        $this->register('TripSorter\BoardingCard\AirportBusBoardingCard');
        $this->register('TripSorter\BoardingCard\TrainBoardingCard');

        // add more boarding cards here
    }

    private function register($className) : void
    {
        if (!class_exists($className)) {
            throw new \Exception('Cannot register boarding card model. Class not found: ' . $className);
        }

        $transportationName = $className::getTransportationName();

        $this->boardingCardsClasses[$transportationName] = $className;
    }
}
