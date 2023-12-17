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

class ShippingTime {
    /**
     * Traveling speed
     * @var int $speed
    */
    private int $speed;

    /**
     * The distance between points.
     * @var float $distance
    */
    private float $distance;

    /**
     * Distance to seconds
     * @var int $seconds
    */
    private int $seconds;

    /**
     * ShippingTime constructor.
     *
     * @param int   $speed    Speed in units per hour.
     * @param float $distance Distance to be covered.
     */
    public function __construct(int $speed, float $distance)
    {
        $this->speed = $speed;
        $this->distance = $distance;
        $this->calculateSeconds();
    }

    /**
     * Calculate the total time required to cover the distance.
     *
     * @return float Time in hours.
     */
    public function toTime(): float
    {
        return $this->distance / $this->speed;
    }

    /**
     * Convert the total time to hours.
     *
     * @return int Hours.
     */
    public function toHours(): int
    {
        return $this->calculateHours();
    }

    /**
     * Get the total time in seconds.
     *
     * @return int Seconds.
     */
    public function toSeconds(): int
    {
        return $this->seconds;
    }

    /**
     * Convert the total time to minutes.
     *
     * @return int Minutes.
     */
    public function toMinutes(): int
    {
        return $this->calculateMinutes();
    }

    /**
     * Convert the total time to days.
     *
     * @return int Days.
     */
    public function toDays(): int
    {
        return $this->calculateDays();
    }

    /**
     * Get a formatted string representation of the total time.
     *
     * @return string Formatted time string.
     */
    public function toString(): string
    {
        $time = $this->toObject();
        return sprintf(
            "%02d day(s) %02d hour(s) %02d minute(s) %02d second(s)",
            $time->days, $time->hours, $time->minutes, $time->seconds
        );
    }

    /**
     * Get an object representation of the total time.
     *
     * @return object Time object with [days, hours, minutes, and seconds]
     */
    public function toObject(): object
    {
        return (object)[
            'days' => $this->calculateDays(),
            'hours' => $this->calculateHours(),
            'minutes' => $this->calculateMinutes(),
            'seconds' => $this->seconds % 60,
        ];
    }

    /**
     * Calculate the total time in seconds.
     */
    private function calculateSeconds(): void
    {
        $this->seconds = (int) ($this->distance / $this->speed) * 3600;
    }

    /**
     * Calculate the total time in hours.
     *
     * @return int Hours.
     */
    private function calculateHours(): int
    {
        return floor(($this->seconds % (24 * 3600)) / 3600);
    }

    /**
     * Calculate the total time in minutes.
     *
     * @return int Minutes.
     */
    private function calculateMinutes(): int
    {
        return floor(($this->seconds % 3600) / 60);
    }

    /**
     * Calculate the total time in days.
     *
     * @return int Days.
     */
    private function calculateDays(): int
    {
        return floor($this->seconds / (24 * 3600));
    }
}
