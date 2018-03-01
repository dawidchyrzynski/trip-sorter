<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class TripSorterTest extends TestCase
{
    /**
     * @dataProvider analyzeBoardingCardsDataProvider
     * @dataProvider analyzeBoardingCardsDataProviderForValidation
     * @dataProvider analyzeBoardingCardsDataProviderForExceptions
     */
    public function testAnalyzeBoardingCards($inputData, $expectedList) : void
    {
        if ($expectedList === false) {
            $this->expectException(\Exception::class);
        }

        $tripSorter = new \TripSorter\TripSorter();
        $result = $tripSorter->analyzeBoardingCards($inputData);

        if (is_array($expectedList)) {
            $list = $result->generateList();

            $this->assertSame($expectedList, $list);
        }
    }

    public function analyzeBoardingCardsDataProvider() : array
    {
        // no boarding cards
        $boardingCardsSet1 = [];

        // the same order as expected list
        $boardingCardsSet2 = [
            $this->mockTrain('Madrid', 'Barcelona', '78A', '45B'),
            $this->mockAirportBus('Barcelona', 'Gerona Airport'),
            $this->mockAirplane('Gerona Airport', 'Stockholm', 'SK455', '45B', '3A', 344),
            $this->mockAirplane('Stockholm', 'New York JFK', 'SK22', 22, '7B')
        ];

        // mixed order
        $boardingCardsSet3 = [
            $this->mockAirplane('Stockholm', 'New York JFK', 'SK22', 22, '7B'),
            $this->mockTrain('Madrid', 'Barcelona', '78A', '45B'),
            $this->mockAirplane('Gerona Airport', 'Stockholm', 'SK455', '45B', '3A', 344),
            $this->mockAirportBus('Barcelona', 'Gerona Airport')
        ];

        // minimal trip
        $boardingCardsSet4 = [
            $this->mockTrain('Madrid', 'Barcelona', '78A', '45B')
        ];

        $expectedList = [
            'Take train 78A from Madrid to Barcelona. Sit in seat 45B.',
            'Take the airport bus from Barcelona to Gerona Airport. No seat assignment.',
            'From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A. '
                . 'Baggage drop at ticket counter 344.',
            'From Stockholm, take flight SK22 to New York JFK. Gate 22, seat 7B. '
                . 'Baggage will we automatically transferred from your last leg.',
            'You have arrived at your final destination.'
        ];

        $expectedMinimalList = [
            'Take train 78A from Madrid to Barcelona. Sit in seat 45B.',
            'You have arrived at your final destination.'
        ];

        return [
            'boarding cards #1' => [$boardingCardsSet1, []],
            'boarding cards #2' => [$boardingCardsSet2, $expectedList],
            'boarding cards #3' => [$boardingCardsSet3, $expectedList],
            'boarding cards #4' => [$boardingCardsSet4, $expectedMinimalList]
        ];
    }

    public function analyzeBoardingCardsDataProviderForValidation()
    {
        // missing departure
        $missingDeparture = ['destination' => 'Warsaw', 'transportation' => 'airport_bus'];

        // missing destination
        $missingDestination = ['departure' => 'Wroclaw', 'transportation' => 'airport_bus'];

        // missing transportation
        $missingTransportation = ['departure' => 'Wroclaw', 'destination' => 'Warsaw'];

        // missing flight for airplane
        $airplaneSet1 = $this->mockAirplane('X', 'Y', 'F', 'G', 'S');
        unset($airplaneSet1['flight']);

        // missing gate for airplane
        $airplaneSet2 = $this->mockAirplane('X', 'Y', 'F', 'G', 'S');
        unset($airplaneSet2['gate']);

        // missing seat for airplane
        $airplaneSet3 = $this->mockAirplane('X', 'Y', 'F', 'G', 'S');
        unset($airplaneSet3['seat']);

        // missing train number for train
        $trainSet1 = $this->mockTrain('X', 'Y', 'T');
        unset($trainSet1['train']);

        return [
            'validation #1' => [[$missingDeparture], false],
            'validation #2' => [[$missingDestination], false],
            'validation #3' => [[$missingTransportation], false],

            // test specific boarding cards
            'validation #4' => [[$airplaneSet1], false],
            'validation #5' => [[$airplaneSet2], false],
            'validation #6' => [[$airplaneSet3], false],
            'validation #7' => [[$trainSet1], false]
        ];
    }

    public function analyzeBoardingCardsDataProviderForExceptions()
    {
        // broken chain
        $boardingCardsSet1 = [
            $this->mockTrain('Madrid', 'Barcelona', '78A', '45B'),
            $this->mockTrain('Madrid', 'Warsaw', '12B', '11A'),
            $this->mockAirportBus('Barcelona', 'Gerona Airport'),
            $this->mockAirplane('Stockholm', 'New York JFK', 'SK22', 22, '7B')
        ];

        // two points with the same departure
        $boardingCardsSet2 = [
            $this->mockTrain('Madrid', 'Barcelona', '78A', '45B'),
            $this->mockTrain('Madrid', 'Warsaw', '12B', '11A'),
            $this->mockAirportBus('Barcelona', 'Gerona Airport'),
            $this->mockAirplane('Gerona Airport', 'Stockholm', 'SK455', '45B', '3A', 344),
            $this->mockAirplane('Stockholm', 'New York JFK', 'SK22', 22, '7B')
        ];

        // circular trip
        $boardingCardsSet3 = [
            $this->mockTrain('Madrid', 'Barcelona', '78A', '45B'),
            $this->mockAirportBus('Barcelona', 'Gerona Airport'),
            $this->mockAirplane('Gerona Airport', 'Stockholm', 'SK455', '45B', '3A', 344),
            $this->mockAirplane('Stockholm', 'Madrid', 'SK22', 22, '7B')
        ];

        return [
            'exceptions #1' => [$boardingCardsSet1, false],
            'exceptions #2' => [$boardingCardsSet2, false],
            'exceptions #3' => [$boardingCardsSet3, false]
        ];
    }

    protected function mockAirplane($from, $to, $flight, $gate, $seat, $baggage = null) : array
    {
        return [
            'departure' => $from,
            'destination' => $to,
            'transportation' => 'airplane',
            'flight' => $flight,
            'gate' => $gate,
            'seat' => $seat,
            'baggage' => $baggage
        ];
    }

    protected function mockAirportBus($from, $to, $seat = null) : array
    {
        return [
            'departure' => $from,
            'destination' => $to,
            'transportation' => 'airport_bus',
            'seat' => $seat
        ];
    }

    protected function mockTrain($from, $to, $train, $seat = null) : array
    {
        return [
            'departure' => $from,
            'destination' => $to,
            'transportation' => 'train',
            'train' => $train,
            'seat' => $seat
        ];
    }
}
