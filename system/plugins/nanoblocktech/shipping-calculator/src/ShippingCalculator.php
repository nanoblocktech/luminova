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

use Luminova\ExtraUtils\ShippingDistance;
use \InvalidArgumentException;

class ShippingCalculator {
    /**
     * Calculate in kilometers from
     * @var string KM
    */
    public const KM = 'km';

    /**
     * Calculate in miles
     * @var string ML
    */
    public const ML = 'ml';

    /**
     * Origin point 
     * @var array $origin
    */
    private array $origin = [];

    /**
     * Destination point 
     * @var array $destination
    */
    private array $destination = [];

    /**
     * Measurement Distance type ('km' for kilometers, 'ml' for miles).
     * @var string $type
    */
    private string $type = 'km';

    /**
     * Initial shipping amount
     * @var float $amount
    */
    private float $amount = 0;

    /**
     * Traveling speed
     * @var int $speed
    */
    private int $speed = 0;

    /**
     * Initialize instance
     *
     * @param string $type Distance type ('km' for kilometers, 'ml' for miles).
    */
    public function __construct(string $type = self::KM)
    {
        $this->type = $type;
    }

    /**
     * Set the origin location.
     *
     * @param float $lat Latitude of the origin.
     * @param float $lng Longitude of the origin.
     * 
     * @return ShippingCalculator $this
     */
    public function setOrigin(float $lat, float $lng): self 
    {
        $this->origin = ['lat' => $lat, 'lng' => $lng];
        return $this;
    }

    /**
     * Set the destination location.
     *
     * @param float $lat Latitude of the destination.
     * @param float $lng Longitude of the destination.
     * 
     * @return ShippingCalculator $this
     */
    public function setDestination(float $lat, float $lng): self 
    {
        $this->destination = ['lat' => $lat, 'lng' => $lng];
        return $this;
    }

    /**
     * Set initial shipping charge per distance.
     *
     * @param float $amount Charge amount per kilometer.
     *
     * @return ShippingCalculator $this
    */
    public function setCharge(float $amount): self 
    {
      $this->amount = $amount;
      return $this;
    }

    /**
     * Set traveling speed per distance
     *
     * @param int $speed
     *
     * @return ShippingCalculator $this
    */
    public function setSpeed(int $speed): self
    {
        if ($speed < 1) {
            throw new InvalidArgumentException("Invalid $speed, speed (speed must be greater than 0)");
        }
        $this->speed = $speed;
        return $this;
    }

    /**
     * Get Distance class instance
     *
     * @return ShippingDistance New distance class instance
     */
    public function getDistance(): ShippingDistance 
    {
        $distance = $this->calculateDistance();
        return new ShippingDistance($distance, $this->type, $this->amount, $this->speed);
    }

    /**
     * Calculate the distance between origin and destination.
     *
     * @return float $distance The calculated distance
    */
    private function calculateDistance(): float 
    {
        $radius = $this->type === self::ML ? 3959 : 6371;

        $originLat = deg2rad($this->origin['lat']);
        $originLng = deg2rad($this->origin['lng']);
        $destinationLat = deg2rad($this->destination['lat']);
        $destinationLng = deg2rad($this->destination['lng']);

        $distanceLat = $destinationLat - $originLat;
        $distanceLng = $destinationLng - $originLng;

        $pointX = sin($distanceLat / 2) * sin($distanceLat / 2) + cos($originLat) * cos($destinationLat) * sin($distanceLng / 2) * sin($distanceLng / 2);
        $pointY = 2 * atan2(sqrt($pointX), sqrt(1 - $pointX));

        $distance = $radius * $pointY;
        return $distance;
    }
}
