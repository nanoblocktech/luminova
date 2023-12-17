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
interface MerchantInterface {
    /**
    * Get api key
    *
    * @return string 
    */
    public function getAuthenticationKey(): string;

   /**
    * Get base api url
    *
    * @return string 
   */
   public function getBaseApi(): string;
}