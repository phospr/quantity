# Quantity

Value objects for quantities.  Inspired by the mathiasverraes/money library.

**The usage below is the proposed usage and has not yet been coded.**

### Usage

```php
$quantity = new Quantity(new Amount(10), Unit::EACH());
```

What about this?

```php
$quantity = new Quantity(Amount::10(), Unit::EACH());
```

### Weight

```php
$pounds = new Weight(new Amount(1), Unit::LB());
$ounces = $weight->convert(Unit::OZ());

echo $ounces->getAmount(); // 16
```
