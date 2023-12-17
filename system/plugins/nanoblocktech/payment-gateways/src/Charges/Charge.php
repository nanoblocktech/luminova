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

use Luminova\ExtraUtils\Payment\Charges\Builder;
use Luminova\ExtraUtils\Payment\Exceptions\PaymentException;

class Charge {
    /**
    * Total amount 
    *
    * @var float $transactionAmount
    */
    private float $transactionAmount = 0;

    /**
    * Total merchant fee  
    *
    * @var float $transactionFee
    */
    private float $transactionFee = 0;

    /**
    * Total shipping fee  
    *
    * @var float $transactionShipping
    */
    private float $transactionShipping = 0;

    /**
    * Merchant fee by rate  
    *
    * @var float|int $transactionRate
    */
    private float|int $transactionRate = 0;
    
    /**
    * Set transaction amount
    *
    * @param int|float|string $amount amount to charges customer 
    *
    * @return self 
    * @throws PaymentException
    */
    public function setAmount(mixed $amount): self 
    {
        if (!is_numeric($amount)) {
            throw new PaymentException('Invalid input. Numeric value expected.');
        }

        $this->transactionAmount = (float) $amount;

        return $this;
    }

    /**
    * Set transaction fee amount
    *
    * @param int|float|string $amount amount to charges customer 
    *
    * @return self 
    * @throws PaymentException
    */
    public function setFee(mixed $amount): self 
    {
        if (!is_numeric($amount)) {
            throw new PaymentException('Invalid input. Numeric value expected.');
        }

        $this->transactionFee = (float) $amount;

        return $this;
    }

    /**
    * Set transaction fee by rate 
    * If setFee is specified, setFeeRate will be ignored
    *
    * @param int|float|string $rate transaction fee rate 
    *
    * @return self 
    * @throws PaymentException
    */
    public function setFeeRate(mixed $rate): self 
    {
        if (!is_numeric($rate)) {
            throw new PaymentException('Invalid input. Numeric value expected.');
        }

        if ($rate > 100) {
            throw new PaymentException('Invalid input. Transaction fee cannot be more than 100%.');
        }

        $this->transactionRate = $rate;

        return $this;
    }

    /**
    * Set transaction shipping fee
    *
    * @param int|float|string $amount transaction shipping fee
    *
    * @return self 
    * @throws PaymentException
    */
    public function setShipping(mixed $amount): self 
    {
        if (!is_numeric($amount)) {
            throw new PaymentException('Invalid input. Numeric value expected.');
        }

        $this->transactionShipping = (float) $amount;

        return $this;
    }

    /**
    * Get transaction charges instance object
    *
    * @return Funds 
    */
    public function build(): Builder 
    {
        $totalCharge = $this->transactionAmount + $this->transactionShipping;

        if ($this->transactionFee > 0) {
            $totalCharge += $this->transactionFee;
        } elseif ($this->transactionRate > 0) {
            $this->transactionFee = ($totalCharge / 100) * $this->transactionRate;
            $totalCharge += $this->transactionFee;
        }

        return new Builder((object) [
            'total' => (float) $totalCharge,
            'fee' => $this->transactionFee,
            'shipping' => $this->transactionShipping,
            'amount' => $this->transactionAmount,
            'rate' => $this->transactionRate,
        ]);
    }
}
