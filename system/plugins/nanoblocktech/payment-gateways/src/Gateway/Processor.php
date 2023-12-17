<?php

/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
*/
namespace Luminova\ExtraUtils\Payment\Gateway;
use Luminova\ExtraUtils\Payment\Exceptions\PaymentException;
use Luminova\ExtraUtils\Payment\Http\Network;
use Luminova\ExtraUtils\Payment\Http\Response;

class Processor  {
    /**
    *
    * @var string base api url 
    */
    private string $apiBase = '';

    /**
    *
    * @var Network network request instance 
    */
    private Network $network;

    /**
    * Initializes process instance 
    * @param string $key api key
    * @param string $base api base url 
    * @param string|null $name merchant name 
    */
    public function __construct(string $key, string $base, ?string $name = null){
        $this->apiBase = $base;
        $this->network = new Network($key);
        if($name !== null){
            $this->network->setMerchantName($name);
        }
    }


    /**
    * Set base api url 
    * @param string $base api base url 
    * 
    * @return self $this
    */
    public function setBase(string $base): self 
    {
        $this->apiBase = $base;
        return $this;
    }

     /**
    * Set payment merchant name
    * @param string $name 
    * 
    * @return self $this
    */
    public function withProcessor(string $name): self 
    {
        $this->network->setMerchantName($name);
        return $this;
    }

    /**
    * Initialize transaction 
    *
    *@param array $fields filed 
    *
    * @return Response 
    * @throws PaymentException
   */
   public function initialize(array $fields): Response 
   {
        $url = "{$this->apiBase}/transaction/initialize";
        $request = $this->network->request($url, 'POST', $fields, false);

        return $request;
   }

   /**
    * Verify payment reference 
    *
    *@param string $reference payment reference
    *
    * @return Response 
    * @throws PaymentException
   */
   public function verify(string $reference): Response 
   {
        $url = "{$this->apiBase}/transaction/verify/" . $reference;
        $request = $this->network->request($url, "GET", null, false);

        return $request;
   }

   /**
    * Verify payment reference 
    *
    * @param int $limit limit
    * @param array $fields fields
    *
    * @return Response 
    * @throws PaymentException
   */
    public function transactions(int $limit = 50, array $fields = []): Response 
    {
        $fields['perPage'] = $limit;
        $url = "{$this->apiBase}/transaction/";
        $request = $this->network->request($url, "GET", $fields, false);

        return $request;
    }

   /**
    * Charge authorization 
    *
    *@param array $fields filed 
    *
    * @return Response 
    * @throws PaymentException
   */
   public function chargeAuthorization(array $fields): Response 
   {
        $url = "{$this->apiBase}/transaction/charge_authorization";
        $request = $this->network->request($url, 'POST', $fields, false);

        return $request;
   }

    /**
    * Charge 
    *
    *@param array $fields filed 
    *
    * @return Response 
    * @throws PaymentException
    */
    public function charge(array $fields): Response 
    {
        $url = "{$this->apiBase}/transaction/charge_authorization";
        $request = $this->network->request($url, 'POST', $fields, false);

        return $request;
    }


   /**
    * Create transfer recipient
    *
    * @param array $fields fields
    *
    * @return Response 
    * @throws PaymentException
   */
   public function createRecipient(array $fields = []): Response 
   {
        if($fields === []){
            $fields = [
            'type' => null,
            'name' => null,
            'account_number' => null,
            'bank_code' => null,
            'currency' => null
            ];
        }
        $url = "{$this->apiBase}/transferrecipient";
        $request = $this->network->request($url, 'POST', $fields, false);

        return $request;
   }

   /**
    * Execute transfer
    *
    * @param array $fields fields
    *
    * @return Response 
    * @throws PaymentException
   */
   public function transfer(array $fields = []): Response 
   {
        if($fields === []){
            $fields = [
            'source' => null,
            'amount' => 0,
            'recipient' => null,
            'reason' => null
            ];
        }
        $url = "{$this->apiBase}/transfer";
        $request = $this->network->request($url, 'POST', $fields, false);
     
        return $request;
   }

}
