<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
*/
namespace Luminova\ExtraUtils\Payment\Charges;

class Builder {

    /**
    * Charges 
    *
    * @var object $charges
    */
    private object $charges;

    /**
    * Initialize Fund class instance
    *
    * @param object $charges
    */
    public function __construct(object $charges){
        $this->charges = $charges;
    }

    /**
    * Get total transaction fee
    *
    * @return float $this->charges->fee
    */
    public function getFee(): float 
    {
        return (float) $this->charges->fee;
    }

    /**
    * Get transaction fee rate 
    *
    * @return int|float $this->charges->rate
    */
    public function getRate(): int|float 
    {
        return $this->charges->rate;
    }

    /**
    * Get total transaction shipping fee
    *
    * @return float $this->charges->shipping
    */
    public function getShipping(): float 
    {
        return (float) $this->charges->shipping;
    }

    /**
    * Get total transaction amount
    *
    * @return float $this->charges->amount
    */
    public function getAmount(): float 
    {
        return (float) $this->charges->amount;
    }

    /**
    * Get total transaction charge
    *
    * @return float $this->charges->total
    */
    public function getTotal(): float 
    {
        return (float) $this->charges->total;
    }

    /**
    * Convert transaction charge to float
    *
    * @return float $this->charges->total
    */
    public function toFloat(): float 
    {
        return $this->charges->total;
    }

    /**
    * Convert transaction charge to integer
    *
    * @return int $this->charges->total
    */
    public function toInt(): int 
    {
        return (int) round($this->charges->total);
    }

    /**
    * Convert transaction charge to integer cent
    *
    * @return int $this->charges->total
    */
    public function toCent(): int 
    {
        return (int) round($this->charges->total * 100);
    }

    /**
    * Convert transaction charge to float cent
    *
    * @return float $this->charges->total
    */
    public function toCentAsFloat(): float 
    {
        return (float) $this->toCent();
    }
}
