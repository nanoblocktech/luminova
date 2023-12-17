<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
*/
namespace Luminova\ExtraUtils\Payment\Merchants;
class MerchantsInstance {
    /**
     * Processor class instance 
     *  @var Processor 
    */
    public $payment;

    /** 
     * Bank class instance
     * @var Bank 
    */
    public $bank;

    /** 
     * Customers class instance
     * @var Customers 
    */
    public $customers;
}