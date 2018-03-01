<?php

namespace TripSorter\BoardingCard;

class BoardingCardBase
{
    private $departure;
    private $destination;
    private $params = [];

    public function setDeparture(string $departure) : void
    {
        $this->departure = $departure;
    }

    public function getDeparture() : string
    {
        return $this->departure;
    }

    public function setDestination(string $destination) : void
    {
        $this->destination = $destination;
    }

    public function getDestination() : string
    {
        return $this->destination;
    }

    public function setParams(array $params) : void
    {
        $this->params = $params;
    }

    public function hasParam(string $name) : bool
    {
        return (isset($this->params[$name]));
    }

    public function getParam(string $name)
    {
        return ($this->hasParam($name) ? $this->params[$name] : null);
    }

    public function hasAllRequiredParams() : bool
    {
        if (!$this->requiredParams) {
            return true;
        }

        foreach ($this->requiredParams as $name) {
            if (!$this->hasParam($name) || empty($this->getParam($name))) {
                return false;
            }
        }

        return true;
    }
}
