### BANKS & DEDICATED VIRTUAL ACCOUNTS

If you are using `getInstance` then you must access the bank instance by using `$merchant->bank->` else if you are working with `getBankInstance` you can directly call the bank class method.


Create dedicated virtual bank account

```php
$result = $bank->createVirtualAccount($customerCode, $bankId, [fields]);
if($result->isSuccess()){
//Do something
}
```

Assign dedicated virtual bank account to customer

```php
$result = $bank->assignVirtualAccount([fields]);
if($result->isSuccess()){
//Do something
}
```
List dedicated virtual accounts

```php
$result = $bank->listVirtualAccount($active, $currency, array $fields = []);
if($result->isSuccess()){
//Do something
}
```

Find dedicated virtual accounts

```php
$result = $bank->findVirtualAccount($account_id);
if($result->isSuccess()){
//Do something
}
```

Re-query dedicated virtual accounts

```php
$result = $bank->queryVirtualAccount(String $account, string $slug, string $date = '');
if($result->isSuccess()){
//Do something
}
```

List dedicated virtual account bank providers

```php
$result = $bank->virtualAccountProviders();
if($result->isSuccess()){
//Do something
}
```

Resolve customer account number and bank verification number

```php
$result = $bank->resolveAccount(string|int $account, string|int $bic);
if($result->isSuccess()){
//Do something
}
```

Resolve customer bank verification number (BVN)

```php
$result = $bank->resolveBvn(string|int $bvn);
if($result->isSuccess()){
//Do something
}
```

List bank in a specific country  

```php
$result = $bank->list(string $country = 'nigeria', int $limit = 50, bool $cursor = false);
if($result->isSuccess()){
//Do something
}
```

Get bank by bank code or name in a specific country 
```php
$result = $bank->get(string|int $identification, string $country = 'nigeria');
if($result->isSuccess()){
//Do something
}
```
