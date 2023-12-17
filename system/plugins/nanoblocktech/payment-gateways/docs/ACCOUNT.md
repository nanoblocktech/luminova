### CUSTOMER ACCOUNT 

If you are using `getInstance` then you must access the customer instance by using `$merchant->customer->` else if you are working with `getCustomerInstance` you can directly call the customer class method.





Initialize customer account with an email address or customer code

```php
$account = $customer->withAccount('CUS_jbf8bq0kbkrk3sc');
```

Create a new customer account and assign it to the current session

```php
$result = $account->create(['array']);
```
Update the current session customer account 

```php
$result = $account->update(['array']);
```

Verify current session customer account 
```php
$result = $account->verify(['array']);
```

Flag current session customer account 
```php
$result = $account->flag(PayStack::FLAG_DENY);
```

Refresh the current session customer account 
```php
$result = $account->refresh();
```

Get property by key name using get method or directly access the object property by name 
```php
$email = $account->get('email');
// OR
$email = $account->email;
```
