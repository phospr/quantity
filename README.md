# Quantity/Quantity

A library to represent various quantities as value objects with the ability to convert from one Unit of Measurement to another.  Inspired by [mathiasverraes/money](https://github.com/mathiasverraes/money/).

A Quantity is made up of an amount (expressed as a [Fraction](https://github.com/yeriki/Fractions)) and a Uom (Unit of Measure).

Currently, only Weight is implemented, but other possibilities include Quantity, Volume, Length etc.

```php
$weight = new Weight(new Fraction(14), new Uom('OZ'));
```

## Usage

#### Creating Uoms

Units of Measure can be created in the following manner.  These two examples are equivalent:

```php
$pounds = new Uom('LB');
$pounds = Uom::LB();
```

#### Creating Quantities

Quantities can be created in any of the following ways.  These three examples are equivalent:

```php
$weight = new Weight(new Fraction(10), new Uom('LB'));
$weight = new Weight(new Fraction(10), Uom::LB());
$weight = Weight::LB(10);
```

#### Converting Quantities

In the following example, we convert 2 lb (pounds) into ounces:

```php
$pounds = Weight::LB(2);
$ounces = $pounds->to(Uom::OZ());

echo $ounces->getAmount(); // 32
```

#### Using Fractions

The amount part of a Quantity is expressed as a [Fraction](https://github.com/yeriki/Fractions).  This allows us to convert Quantities accurately:

```php
$ounces = Weight::OZ(28);
$pounds = $ounces->to(Uom::LB());
echo $pounds; // 1 3/4 LB
```


## Installation

```json
{
    "require": {
        "quantity/quantity": "dev-master"
    }
}
```
