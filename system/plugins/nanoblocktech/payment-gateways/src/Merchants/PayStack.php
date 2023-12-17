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

use Luminova\ExtraUtils\Payment\MerchantInterface;

class PayStack implements MerchantInterface {

   /**
    * @var string FLAG_DEFAULT default customer access
   */
   public const FLAG_DEFAULT = 'default';

   /**
    * @var string FLAG_ALLOW allow customer access
   */
   public const FLAG_ALLOW = 'allow';

   /**
    * @var string FLAG_DENY deny customer access
   */
   public const FLAG_DENY = 'deny';

   /**
    *
    * @var string $apiBase base api url 
   */
   private string $apiBase = "https://api.paystack.co";

   /**
    *
    * @var string $merchantAuthKey account api private key
   */
	private string $merchantAuthKey = '';

   /**
    *
    * @var string $key api private key
   */
   public function __construct(string $key)
   {
      $this->merchantAuthKey = $key;
   }

   /**
    * Get api key
    *
    * @return string 
   */
   public function getAuthenticationKey(): string 
   {
      return $this->merchantAuthKey;
   }

   /**
    * Get base api url
    *
    * @return string 
   */
   public function getBaseApi(): string 
   {
      return $this->apiBase;
   }

}
