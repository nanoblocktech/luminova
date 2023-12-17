## Class Shipping Calculator

Determines the shipping fee based on the customer's longitude and latitude to the business location.

### Functions

- Calculates the distance between business and customer locations
- Determines the shipping fee based on the provided charge per distance.
- Determines the estimated traveling time based on distance and speed

Installation Guide via Composer:

```bash
composer require nanoblocktech/shipping-calculator
```

### Usages 

```php
use Luminova\ExtraUtils\ShippingCalculator;

$calculator = new ShippingCalculator();

// Set business and customer locations

$calculator->setOrigin(6.47427, 7.56196); // Business location (Enugu Airport Nigeria)
$calculator->setDestination(6.51181, 7.35535); // Customer location (Udi Nigeria)
$calculator->setCharge(100); // Initial shipping cost per distance km, or ml

// Calculate distance and return new ShippingDistance instance class

$distance = $calculator->getDistance();

// Get the estimated time information

$time = $calculator->getTime();

// Get your calculated information

echo "Distance: $distance->toDistance() \n";
echo "Distance[km|ml]: $distance->toString() \n";
echo "Shipping Fee: $distance->getCurrency(2)\n";
echo "Shipping Fee: $distance->getCharges()\n";
```

### Methods 

#### ShippingCalculator

Setting up your calculations `$calculator = new ShippingCalculator(ShippingCalculator::KM);`

Methods And Param                                       |  Descriptions 
--------------------------------------------------------|-----------------------------------------------------
setOrigin(float latitude, float longitude): self        | Set the origin location latitude and longitude
setDestination(float latitude, float longitude): self   | Set the destination location latitude and longitude
setCharge(float amount): self                           | Set initial shipping charge per calculation distance
setSpeed(int speed): self                               | Set speed in units per hour, to calculate estimated time.
getDistance(): ShippingDistance                         | Calculate the distance between the origin/destination and return distance instance.

#### ShippingDistance

The method which `$distance = $calculator->getDistance();` is returned 

Methods And Param                                       |  Descriptions 
--------------------------------------------------------|-----------------------------------------------------------------------------------------
toDistance(): float                                     | Get the calculated distance between the origin and destination latitude and longitude.
toString(): string                                      | Get the distance as a string (e.g., '10km').
toCurrency(int decimals = 2, string symbol): string     | Convert the distance to currency format with optional currency symbol and decimal places.
toMile(): float                                         | Convert the distance from kilometer to miles.
toKilometer(): float                                    | Convert the distance from miles to kilometers.
getCurrency(int decimal = 2): string                    | Get the calculated currency value based on the distance and initial amount.
getCharges(): float                                     | Get the calculated charges
getTime(): ShippingTime                                 | Get distance time instance

#### ShippingTime

The method which `$time = $distance->getTime();` is returned 

Methods And Param                                       |  Descriptions 
--------------------------------------------------------|-----------------------------------------------------------------------------------------
toTime(): float                                         | Get the calculated time required to cover the distance.
toHours(): int                                          | Convert the total time to hours.
toSeconds(): int                                        | Get the total time in seconds.
toMinutes(): int                                        | Convert the total time to minutes.
toDays(): int                                           | Convert the total time to days.
toString(): string                                      | Get a formatted string representation of the total time.
toObject(): object                                      | Get an object representation of the total time.

