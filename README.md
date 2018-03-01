# Trip sorter

## Task

You are given a stack of boarding cards for various transportations that will take you from a point A to point B via several stops on the way. All of the boarding cards are out of order and you don't know where your journey starts, nor where it ends. Each boarding card contains information about seat assignment, and means of transportation (such as flight number, bus number etc).

Write an API that lets you sort this kind of list and present back a description of how to complete your journey. For instance the API should be able to take an unordered set of boarding cards, provided in a format defined by you, and produce this list:

1. Take train 78A from Madrid to Barcelona. Sit in seat 45B.
2. Take the airport bus from Barcelona to Gerona Airport. No seat assignment.
3. From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A. Baggage drop at ticket counter 344.
4. From Stockholm, take flight SK22 to New York JFK. Gate 22, seat 7B. Baggage will we automatically transferred from your last leg.
5. You have arrived at your final destination. The list should be defined in a format that's compatible with the input format. The API is to be an internal PHP API so it will only communicate 6. with other parts of a PHP application, not server to server, nor server to client. Use PHP-doc to document the input and output your API accepts / returns.

## Requirements

PHP version greater or equal 7.1.0 is required.

## How to to run

```
composer install
composer test
php index.php
```

Please note that `composer test` command runs both PHPCS check and PHPUnit tests.

## About the algorithm

## Limitations

## Adding new boarding cards

## Time log

1. 30m - plan of action (project structure, classes names)
2. 10m - prepare initial project structure including empty classes
3. 20m - implement unit tests (at this stage all are failing)
4. 15m - implement boarding cards models
5. 15m - implement trip representation, factory and cards processor
