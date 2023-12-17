<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
*/
namespace Luminova\ExtraUtils\Payment;

use Luminova\ExtraUtils\Payment\MerchantInterface;
use Luminova\ExtraUtils\Payment\Gateway\Processor as Payment;
use Luminova\ExtraUtils\Payment\Customers\Customers;
use Luminova\ExtraUtils\Payment\Banks\Bank;
use Luminova\ExtraUtils\Payment\Utils\Helper;
use Luminova\ExtraUtils\Payment\Merchants\MerchantsInstance;
use Luminova\ExtraUtils\Payment\Exceptions\PaymentException;

class Merchant {
    /**
    * @var MerchantsInstance static process instance  
    */
    private static $instance = null;

    /**
     * Initialize process singleton payment instance 
     * 
     * @param MerchantInterface $merchant client instance 
     * 
     * @return MerchantsInstance static merchants class instance 
    */

    public static function getInstance(MerchantInterface $merchant): MerchantsInstance 
    {
        if ($merchant instanceof MerchantInterface) {
            if (static::$instance === null) {
                $key = $merchant->getAuthenticationKey();
                $base = $merchant->getBaseApi();
                $with = Helper::whichMerchant($merchant);
                
                static::$instance = new MerchantsInstance();
                static::$instance->payment = new Payment($key, $base, $with);
                static::$instance->bank = new Bank($key, $base, $with);
                static::$instance->customers = new Customers($key, $base, $with);
            }
            return static::$instance;
        }

        throw new PaymentException('Invalid argument: $merchant must implement MerchantInterface.');
    }

    /**
     * Initialize process payment instance 
     * 
     * @param MerchantInterface $merchant client instance 
     * 
     * @return Payment static process class instance 
    */
    public static function getPaymentInstance(MerchantInterface $merchant): Payment 
    {
        $payment = new Payment($merchant->getAuthenticationKey(), $merchant->getBaseApi());
        $payment->withProcessor(Helper::whichMerchant($merchant));
        return $payment;
    }

     /**
     * Initialize customer instance 
     * 
     * @param MerchantInterface $merchant client instance 
     * 
     * @return Customers static process class instance 
    */
    public static function getCustomerInstance(MerchantInterface $merchant): Customers
    {
        $customer = new Customers($merchant->getAuthenticationKey(), $merchant->getBaseApi());
        $customer->withProcessor(Helper::whichMerchant($merchant));
        return $customer;
    }

    /**
     * Initialize bank instance 
     * 
     * @param MerchantInterface $merchant client instance 
     * 
     * @return Bank static process class instance 
    */
    public static function getBankInstance(MerchantInterface $merchant): Bank
    {
        $bank = new Bank($merchant->getAuthenticationKey(), $merchant->getBaseApi());
        $bank->withProcessor(Helper::whichMerchant($merchant));
        return $bank;
    }
}
