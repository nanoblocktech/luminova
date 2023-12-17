### CUSTOMERS

If you are using `getInstance` then you must access the customer instance by using `$merchant->customer->` else if you are working with `getCustomerInstance` you can directly call the customer class method.

Create customer account 

```php
$result = $customer->create([
    'metadata' => [=
        'key' => "Value"
    ],
    'first_name' => "Peter",
    'last_name' => "Foo",
    'phone' => "000000",
    'email' => "peter@example.com",
]);
if($result->isSuccess()){
//Do something
}
```

Update customer account
```php
$result = $customer->update($customerCode, [
    'first_name' => "Peter",
    'last_name' => "Bar",
    'phone' => "1111111",
    'email' => "peter@example.com",
]);
if($result->isSuccess()){
//Do something
}
```


Flag customer accounts based on risk level
Allowed flags `PayStack::FLAG_DEFAULT`, `PayStack::FLAG_ALLOW`, or `PayStack::FLAG_DENY`

```php
$result = $customer->flag($customerCode, PayStack::FLAG_DENY);
if($result->isSuccess()){
//Do something
}
```

Verify customer account

```php
$result = $customer->verify($customerCode, ['array']);
if($result->isSuccess()){
//Do something
}
```

List customers 

```php
$result = $customer->list($limit);
```

Find customer by email address or customer code 

```php
$result = $customer->find('CUS_jbf8bq0kbkrk3sc');
```
