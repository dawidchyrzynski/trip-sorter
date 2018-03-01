<?php

require_once('vendor/autoload.php');

$tripSorter = new TripSorter\TripSorter();
$boardingCards = [];

try {
    $result = $tripSorter->analyzeBoardingCards($boardingCards);

    $result->print();
} catch (\Exception $ex) {
    echo $ex->getMessage() , PHP_EOL;
}
