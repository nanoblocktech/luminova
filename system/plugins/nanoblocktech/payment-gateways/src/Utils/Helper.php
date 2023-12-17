<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
*/
namespace Luminova\ExtraUtils\Payment\Utils;

use Luminova\ExtraUtils\Payment\Exceptions\PaymentException;
class Helper {

    /**
     * Paystack risk actions 
     * @var array RISK_ACTIONS
    */
    public const RISK_ACTIONS = [
        'default', 'allow', 'deny'
    ];

    /**
     * Format a mixed value as a currency with two decimal places.
     *
     * @param mixed $amount The value to be formatted as currency.
     *
     * @return float The formatted currency value.
    */
    public static function formatCurrency(mixed $amount): float 
    {
        return (float) number_format((float) $amount, 2, '.', '');
    }

    /**
     * Convert a mixed value to cents.
     *
     * @param mixed $amount The value to be converted to cents.
     *
     * @return float The value in cents.
    */
    public static function toCentFloat(mixed $amount): float 
    {
        if (!is_numeric($amount)) {
            throw new PaymentException('Invalid input. Numeric value expected.');
        }

        return (float) ($amount * 100);
    }

    /**
     * Convert a mixed value to cents.
     *
     * @param mixed $amount The value to be converted to cents.
     *
     * @return int The value in cents.
    */
    public static function toCent(mixed $amount): int 
    {
        if (!is_numeric($amount)) {
            throw new PaymentException('Invalid input. Numeric value expected.');
        }

        return (int) round($amount * 100);
    }

    /**
     * Get merchant name from MerchantInterface class 
     * 
     * @param object $class client instance 
     * 
     * @return string Class name
    */
    public static function whichMerchant(object $class): string
    {
        $namespace = get_class($class);
        $path = explode('\\', $namespace);
        return end($path);
    }

    /**
     * Check if requested array has all required keys 
     * 
     * @param array $keys original array keys
     * @param array $keys original requested array
     * 
     * @return boolean
    */
    public static function isPassedRequired(array $keys, array $fields): bool 
    {
        return !array_diff_key(array_flip($keys), $fields);
    }

    /**
     * Retrieve missing required keys 
     * 
     * @param array $keys original array keys
     * @param array $keys original requested array
     * 
     * @return string $missing list of missing keys 
    */
    public static function listFailedRequired(array $keys, array $fields): string 
    {
        $keyDifference = array_diff($keys, array_keys($fields));
        $missing = implode(', ', $keyDifference);
        return $missing;
    }
}
