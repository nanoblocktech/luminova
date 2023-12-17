### CHARGE

You can use charge class to calculate and build your transaction fee

Register Charges namespace 

```php 
use Luminova\ExtraUtils\Payment\Charges;
```

Initialize  charge class instance 

```php
$charge = new Charge();
```
Set total transaction amount (Required)

```php
$charge->setAmount($amount);
```
Set transaction fee or merchant fee (Optional)

```php
$charge->setFee($amount);
```

Or Set transaction fee by rate `1.7%` (Optional)
```php
$charge->setFeeRate($rate);
```

Set shipping fee (Optional)
```php
$charge->setShipping($amount);
```

Build your charges 
```php
$builder = $charge->build();
```

**Get charges after building**

Get total amount 
```php
$totalFloat = $builder->getTotal();
```

Get total as integer
```php
$totalInt = $builder->toInt();
```

Convert total to cent integer
```php
$centInt = $builder->toCent();
```

Convert total to cent float
```php
$centFloat = $builder->toCentAsFloat();
```

Get Fee
```php
$fee = $builder->getFee();
```
