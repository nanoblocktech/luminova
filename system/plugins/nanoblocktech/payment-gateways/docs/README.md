
### PayStack Initialize

To initialize the payment gateway you will need to pass the merchant interface you want to use 

First, initialize your payment merchant gateway

```php 
$gateway = new PayStack("PAYMENT_PRIVATE_KEY");
```

Calling `Merchant::getInstance` will return instances of `Bank`, `Customers`, and `Processor as Payment`
which can then be used to access individual class instances `$merchant->bank->foo()`

```php
$merchant = Merchant::getInstance($gateway);
```

Initialize with payment instance 

```php
$payment = Merchant::getPaymentInstance($gateway);
```

Initialize with customer instance 
```php
$customer = Merchant::getCustomerInstance($gateway);
```

Initialize with a bank instance 
```php
$bank = Merchant::getBankInstance($gateway);
```
