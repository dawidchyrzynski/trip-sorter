<?php

require_once('vendor/autoload.php');

$tripSorter = new TripSorter\TripSorter();
$boardingCards = [
    [
        'departure' => 'Madrid',
        'destination' => 'Barcelona',
        'transportation' => 'train',
        'train' => '78A',
        'seat' => '45B'
    ],
    [
        'departure' => 'Barcelona',
        'destination' => 'Gerona Airport',
        'transportation' => 'airport_bus',
        'seat' => null
    ],
    [
        'departure' => 'Gerona Airport',
        'destination' => 'Stockholm',
        'transportation' => 'airplane',
        'flight' => 'SK455',
        'gate' => '45B',
        'seat' => '3A',
        'baggage' => 344
    ],
    [
        'departure' => 'Stockholm',
        'destination' => 'New York JFK',
        'transportation' => 'airplane',
        'flight' => 'SK22',
        'gate' => 22,
        'seat' => '7B'
    ]
];

try {
    $result = $tripSorter->analyzeBoardingCards($boardingCards);

    $result->print();
} catch (\Exception $ex) {
    echo $ex->getMessage() , PHP_EOL;
}
