
### PAYMENTS & TRANSACTIONS

If you are using `getInstance` then you must access the payment instance by using `$merchant->payment->` else if you are working with `getPaymentInstance` you can directly call the payment class method.

Initialize payment from backend 

```php
$result = $payment->initialize(['array']);
if($result->isSuccess()){
//Do something
}
```

Charge customer card

```php
$result = $payment->charge(['array']);
if($result->isSuccess()){
//Do something
}
```

Charge customer card authorization code

```php
$result = $payment->chargeAuthorization(['array']);
if($result->isSuccess()){
//Do something
}
```

verify payment with transaction reference number 

```php
$result = $payment->verify($reference);
if($result->isSuccess()){
//Do something
}
```
