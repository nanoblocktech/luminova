<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
*/
namespace Luminova\ExtraUtils;

use \Luminova\ExtraUtils\ShippingTime;
use \InvalidArgumentException;

class ShippingDistance
{
    /**
     * The distance between points.
     * @var float $distance
    */
    private float $distance = 0.0;

    /**
     * The measurement unit for distance (e.g., 'km', 'ml').
     * @var string $type
    */
    private string $type = 'km';

    /**
     * The initial shipping amount.
     * @var float $amount
    */
    private float $amount = 0;

    /**
     * Traveling speed
     * @var int $speed
    */
    private int $speed = 0;

    /**
     * ShippingDistance constructor.
     *
     * @param float $distance The distance between points.
     * @param string $type The measurement unit for distance (e.g., 'km', 'ml').
     * @param float $amount The initial shipping amount.
     */
    public function __construct(float $distance, string $type, float $amount, int $speed)
    {
        $this->distance = $distance;
        $this->type = $type;
        $this->amount = $amount;
        $this->speed = $speed;
    }

    /**
     * Get the distance between points.
     *
     * @return float The distance.
    */
    public function toDistance(): float
    {
        return $this->distance;
    }

    /**
     * Get the distance as a string (e.g., '10km').
     *
     * @return string The formatted distance string.
     */
    public function toString(): string
    {
        return $this->distance . $this->type;
    }

    /**
     * Convert the distance to currency format with optional symbol and decimal places.
     *
     * @param int $decimal The number of decimal places.
     * @param string|null $symbol The currency symbol.
     * 
     * @return string The formatted currency string.
     */
    public function toCurrency(int $decimal = 2, string $symbol = null): string
    {
        return $symbol === null ?:$symbol . $this->getCurrency($decimal);
    }

    /**
     * Convert the distance from kilometer to miles.
     *
     * @return float The distance in miles.
     */
    public function toMile(): float
    {
        return ($this->type === 'km') ? $this->distance * 0.621371 : $this->distance;
    }

    /**
     * Convert the distance from miles to kilometers.
     *
     * @return float The distance in kilometers.
    */
    public function toKilometer(): float
    {
        return ($this->type === 'ml') ? $this->distance * 1.60934 : $this->distance;
    }

    /**
     * Get the calculated charges
     *
     * @return float 
     */
    public function getCharges(): float
    {
        return $this->amount * $this->distance;
    }

    /**
     * Get the currency value based on the distance and initial amount.
     *
     * @param int $decimal The number of decimal places.
     * @return string The formatted currency value.
    */
    public function getCurrency(int $decimal = 2): string
    {
        return number_format($this->getCharges(), $decimal, '.', ',');
    }

    /**
     * Get ShippingTime instance to calculate 
     * shipping distance traveling durations
     * 
     * @return ShippingTime Shipping distance time instance
    */
    public function getTime(): ShippingTime
    {
        if ($this->speed < 1) {
            throw new InvalidArgumentException("Invalid speed (speed must be greater than 0)");
        }
        return new ShippingTime($this->speed, $this->distance);
    }
}
