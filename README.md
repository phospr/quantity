# Quantity

Value objects for quantities.  Inspired by the mathiasverraes/money library.

## Usage

**The usage below is the proposed usage and has not yet been coded.**

### Simple Quantities

The following three examples are equivalent

```php
$quantity = new Quantity(new Amount(10), new Uom('EACH'));
$quantity = new Quantity(new Amount(10), Uom::EACH());
$quantity = Quantity::EACH(10);
```

$dozen = Quantity::DOZEN(3);

### Weight

```php
$pounds = Weight::LB(2);
$ounces = $pounds->convertTo(Unit::OZ());

echo $ounces->getAmount(); // 32
```
