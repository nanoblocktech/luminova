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

use Luminova\ExtraUtils\Payment\Customers\Customers;
use Luminova\ExtraUtils\Payment\Exceptions\PaymentException;
use Luminova\ExtraUtils\Payment\Http\Response;

class Account {

    /**
    * @var Customers $customer class instance
    */
    private Customers $customers;

    /**
    * @var string $identifier customer email or code
    */
    private string $identifier = '';

    /**
    * @var array $fields customer account fields
    */
    private array $fields = [
        'email' => '',
        'first_name' => '',
        'last_name' => '',
        'phone' => '',
        'metadata' => [],
        'transactions' => [],
        'subscriptions' => [],
        'authorizations' => []
    ];

    /**
    * Initializes customer instance 
    * @param object $account
    * @param string $identifier
    */
    public function __construct(Customers $customers, object $account, string $identifier){
        $this->fields = (array) $account;
        $this->identifier = $identifier;
        $this->customers = $customers;
    }

    /**
    * Get customer account information
    *
    * @param string $key 
    * 
    * @return mixed Null is returned if property does not exist
    */
    public function __get(string $key): mixed
    {
        return $this->get($key);
    }

    /**
    * Get customer account information
    *
    * @param string $key 
    * 
    * @return mixed Null is returned if property does not exist
    */
    public function get(string $key): mixed
    {
        return isset($this->fields[$key]) ? $this->fields[$key] : null;
    }

    /**
    * Refresh customer account 
    *
    * @return bool
    * @throws PaymentException
    */
    public function refresh(): bool 
    {
        if($this->identifier === ''){
            throw new PaymentException('Customer identifier required, make sure you called withEmail() or withCode() before updating customer.');
        }

        $result = $this->customers->find($this->identifier);
        if($result->isSuccess()){
            $this->fields = (array) $result->getData();
            return true;
        }

        return false;
    }

    /**
    * Flag customer account 
    *
    * @param string $risk Customer risk action code
    * @param bool $global Is executing globally 
    *
    * @return bool 
    * @throws PaymentException
    */
    public function flag(string $risk): bool 
    {
        if($this->identifier === ''){
            throw new PaymentException('Customer identifier required, make sure you called withEmail() or withCode() before updating customer.');
        }

        $result = $this->customers->flag($this->identifier, $risk);
        if($result->isSuccess()){
            $this->fields['flag'] = $risk;
            return true;
        }
        return false;
    }

    /**
    * Create customer account 
    *
    * @param array $fields  Customer fields
    * 
    * @return object 
    * @throws PaymentException
    */
    public function create(array $fields = []): object 
    {
        return $this->customers->create($fields);
    }

   /**
    * Update customer account 
    *
    * @param array $fields Customer fields
    *
    * @return Response 
    * @throws PaymentException
    */
    public function update(array $fields): Response 
    {
        if($this->identifier === ''){
            throw new PaymentException('Customer identifier required, make sure you called withEmail() or withCode() before updating customer.');
        }

        return $this->customers->update($this->identifier, $fields);
    }

    /**
    * Validate customer account 
    *
    * @param array $fields Customer fields assistive array 
    *
    * @return Response 
    * @throws PaymentException
    */
    public function verify(array $fields): Response 
    {

        if($this->identifier === ''){
            throw new PaymentException('Customer identifier required, make sure you called withEmail() or withCode() before updating customer.');
        }

        $fields['first_name'] = $this->fields['first_name'];
        $fields['last_name'] = $this->fields['first_name'];

        return $this->customers->verify($this->identifier, $fields);
    }
   
}
