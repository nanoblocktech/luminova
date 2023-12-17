<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
*/
namespace Luminova\ExtraUtils\Payment\Customers;

use Luminova\ExtraUtils\Payment\Http\Network;
use Luminova\ExtraUtils\Payment\Http\Response;
use Luminova\ExtraUtils\Payment\Utils\Helper;
use Luminova\ExtraUtils\Payment\Customers\Account;
use Luminova\ExtraUtils\Payment\Exceptions\PaymentException;

class Customers {

    /**
    * @var string base api url 
    */
    private string $apiBase = '';

    /**
    * @var Network network request instance 
    */
    private Network $network;

    /**
    * Initializes customers instance 
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
    * Set payment merchant name
    * @param string $name 
    * 
    * @return self $this
    */
    public function withProcessor(string $name): self {
        $this->network->setMerchantName($name);
        return $this;
    }

    /**
    * Initialize customer account with email address
    *
    *@param string $identifier Customer account email or code identifier
    *
    * @return Customer
    * @throws PaymentException
    */
    public function withAccount(string $identifier): Account 
    {
        if($identifier === ''){
            throw new PaymentException('Customer identifier required, customer account email or code cannot be empty.');
        }

        $account = $this->find($identifier);
        if($account === null){
            throw new PaymentException('Customer account not found.');
        }
        return new Account($this, $account, $identifier);
    }

    /**
    * Create customer account 
    *
    * @param array $fields Customer fields
    * 
    * @return Response 
    * @throws PaymentException
    */
    public function create(array $fields = []): Response 
    {
        $url = "{$this->apiBase}/customer";
        $result = $this->network->request($url, 'POST', $fields, false);

        return $result;
    }

    /**
    * Update customer account 
    *
    * @param array $identifier Customer identifier code
    * @param array $fields Customer fields
    *
    * @return Response 
    * @throws PaymentException
    */
    public function update(string $identifier, array $fields): Response 
    {
        if($identifier === ''){
            throw new PaymentException('Customer identifier required.');
        }

        $url = "{$this->apiBase}/customer/{$identifier}";
        $result = $this->network->request($url, 'POST', $fields, false);

        return $result;
    }

    /**
    * List customers 
    *
    * @param int $limit limit number of customers
    *
    * @return Response 
    * @throws PaymentException
    */
    public function list(int $limit = 50): Response 
    {
        $url = "{$this->apiBase}/customer";
        $fields = ['perPage' => $limit];
        $result = $this->network->request($url, "GET", $fields, true);

        return $result;
    }

    /**
    * Find customer account 
    *
    * @param string $identifier Customer email or code
    *
    * @return Response
    * @throws PaymentException
    */
    public function find(string $identifier): Response 
    {
        $url = "{$this->apiBase}/customer/{$identifier}";
        $result = $this->network->request($url, "GET", null, true);

        return $result;
    }

    /**
    * Flag customer account 
    *
    * @param string $identifier Customer code identifier
    * @param string $risk Customer risk action code
    *
    * @return Response 
    * @throws PaymentException
    */
    public function flag(string $identifier, string $risk): Response 
    {
        if($identifier === ''){
            throw new PaymentException('Customer identifier required.');
        }

        $risk = strtolower($risk);
        if(in_array($risk, Helper::RISK_ACTIONS)){
            $fields = [
                'customer' => $identifier,
                'risk_action' => $risk
            ];
            $url = "{$this->apiBase}/customer/set_risk_action";
            $result = $this->network->request($url, 'POST', $fields, false);
            return $result;
        }

        throw new PaymentException('Invalid risk action. Supported risk actions: default, allow, deny.');
    }

    /**
    * Validate customer account 
    *
    * @param array $code Customer code
    * @param array $fields Customer fields assistive array 
    *
    * @return Response 
    * @throws PaymentException
    */
    public function verify(string $code, array $fields): Response 
    {

        $url = "{$this->apiBase}/customer/{$code}/identification";
        $result = $this->network->request($url, 'POST', $fields, false);

        return $result;
    }
   
}
