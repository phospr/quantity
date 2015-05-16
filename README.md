# Quantity

Value objects for quantities.  Inspired by the mathiasverraes/money library.

**The usage below is the proposed usage and has not yet been coded.**

### Usage

```php
$quantity = new Quantity(new Fraction(10), new Unit('each'));
```

### Weight

```php
$pounds = new Weight(new Fraction(1), Unit::LB());
$ounces = $weight->convert(Unit::OZ());

echo $ounces->getAmount(); // 16
```
