<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
*/
namespace Luminova\ExtraUtils\Payment\Banks;

use Luminova\ExtraUtils\Payment\Exceptions\PaymentException;
use Luminova\ExtraUtils\Payment\Http\Network;
use Luminova\ExtraUtils\Payment\Http\Response;
use Luminova\ExtraUtils\Payment\Utils\Helper;

class Bank {

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
    public function __construct(string $key, string $base, ?string $name = null)
    {
        $this->apiBase = $base;
        $this->network = new Network($key);
        if($name !== null){
            $this->network->setMerchantName($name);
        }
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
    * Create a dedicated virtual bank account
    *
    * @param string $identifier Customer id or code identifier 
    * @param string $bank Preferred bank id  
    * @param array $fields Optional fields
    *
    * @return Response 
    * @throws PaymentException
    */
    public function createVirtualAccount(string $identifier, string $bank = 'wema-bank', array $fields = []): Response 
    {
        $fields['customer'] = $identifier;
        $fields['preferred_bank'] = $bank;
        $url = "{$this->apiBase}/dedicated_account";
        $result = $this->network->request($url, "POST", $fields, false);

        return $result;
    }

    /**
    * Create a dedicated virtual bank account
    *
    * @param string $identifier Customer id or code identifier 
    * @param string $bank Preferred bank id  
    * @param array $fields Optional fields
    *
    * @return Response 
    * @throws PaymentException
    */
    public function assignVirtualAccount(array $fields): Response 
    {
        $requiredKeys = ['email', 'first_name', 'last_name', 'phone', 'preferred_bank', 'country'];

        if (Helper::isPassedRequired($requiredKeys, $fields)) {
            $url = "{$this->apiBase}/dedicated_account";
            $result = $this->network->request($url, "POST", $fields, false);

            return $result;
        }

        $missingKeys = Helper::listFailedRequired($requiredKeys, $fields);
        throw new PaymentException("Missing required keys: $missingKeys.");
    }

    /**
    * Create a dedicated virtual bank account
    *
    * @param bool $status List by account status
    * @param string $currency List by currency code 
    * @param array $fields Optional fields
    *
    * @return Response 
    * @throws PaymentException
    */
    public function listVirtualAccount(bool $status = true, string $currency = 'NGN', array $fields = []): Response 
    {
        $fields['active'] = $fields['active'] ?? $status;
        $fields['currency'] = $fields['currency'] ?? $currency;
        $url = "{$this->apiBase}/dedicated_account";
        $result = $this->network->request($url, "GET", $fields, true);

        return $result;
    }

    /**
    * Create a dedicated virtual bank account
    *
    * @param string $id Find account by dedicated account id
    *
    * @return Response 
    * @throws PaymentException
    */
    public function findVirtualAccount(String $id): Response 
    {
        $url = "{$this->apiBase}/dedicated_account/{$id}";
        $result = $this->network->request($url, "GET", null, true);

        return $result;
    }

     /**
    * Create a dedicated virtual bank account
    *
    * @param string $account Dedicated virtual bank account number
    * @param string $slug Virtual bank account provider slug
    * @param string $date Optional date format [yyyy-mm-dd]
    *
    * @return Response 
    * @throws PaymentException
    */
    public function queryVirtualAccount(String $account, string $slug, string $date = ''): Response 
    {
        $url = "{$this->apiBase}/dedicated_account/requery?account_number={$account}&provider_slug={$slug}&date={$date}";
        $result = $this->network->request($url, "GET", null, true);

        return $result;
    }

    /**
    * List bank providers for dedicated virtual account
    *
    * @return Response 
    * @throws PaymentException
    */
    public function virtualAccountProviders(): Response 
    {
        $url = "{$this->apiBase}/dedicated_account/available_providers";
        $result = $this->network->request($url, "GET", null, true);

        return $result;
    }

    /**
    * Resolve account number
    *
    * @param string|int $account account number 
    * @param string|int $bic bank code 
    *
    * @return Response 
    * @throws PaymentException
    */
    public function resolveAccount(string|int $account, string|int $bic): Response 
    {
        $url = "{$this->apiBase}/bank/resolve?account_number=".$account."&bank_code=".$bic;
        $request = $this->network->request($url, "GET", null, true);

        return $request;
    }

    /**
    * Resolve BVN number
    *
    * @param string|int $bvn Bank Verification Number (BVN)
    *
    * @return Response 
    * @throws PaymentException
    */
    public function resolveBvn(string|int $bvn): Response 
    {
        $url = "{$this->apiBase}/bank/resolve_bvn/".$bvn;
        $request = $this->network->request($url, "GET", null, true);

        return $request;
    }

    /**
    * List banks in a specified country 
    * 
    * @param string $country 
    * @param int $limit number of banks to return
    * @param bool $cursor 
    *
    * @return Response 
    * @throws PaymentException
   */
   public function list(string $country = 'nigeria', int $limit = 50, bool $cursor = false): Response 
   {
        $fields = [
            'country' => $country,
            'perPage' => $limit,
            'use_cursor' => $cursor
        ];
        $url = "{$this->apiBase}/bank";
        $request = $this->network->request($url, "GET", $fields, true);

        return $request;
   }


   /**
    * Get bank by name or bank identification
    *
    * @param string $identification bank name or bank id 
    *
    * @return object 
    * @throws PaymentException
   */
   public function get(string|int $identification): object
   {
        $result = $this->list();
        if($result->isSuccess()){
            foreach($result->getData() as $value){
                if($value->code === $identification || strtolower($value->name) === strtolower($identification)){
                    return (object) $value;
                }
            }
        }
        throw new PaymentException('Failed to retrieve bank information.');
   }
   
    /**
    * Create a dedicated virtual bank account
    *
    * @param string $id Find account by dedicated account id
    *
    * @deprecated Abandoned since version X.Y.Z
    * @return object 
    */
    public function deactivateVirtualAccount(String $id): object 
    {
 
        return (object)[];
    }
   
}
