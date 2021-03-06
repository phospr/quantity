<?php

/*
 * This file is part of the Phospr Quantity package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phospr;

use InvalidArgumentException;
use Phospr\Fraction;
use Phospr\Exception\Quantity\InvalidUomException;

/**
 * AbstractQuantity
 *
 * A base value object for various types of quantity: weight, length, volume,
 * etc. Made up of an amount (Fraction) and a Uom
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.3.0
 */
abstract class AbstractQuantity
{
    /**
     * $amount
     *
     * @var Fraction
     */
    protected $amount;

    /**
     * uom
     *
     * @var Uom
     */
    protected $uom;

    /**
     * Constructor
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.3.0
     *
     * @param Fraction $amount
     * @param Unit     $unit
     *
     * @throws \Quantity\InvalidAmountException
     */
    public function __construct(Fraction $amount, Uom $uom)
    {
        $reflection = new \ReflectionClass($this);
        $subClassName = $reflection->getShortName();
        $uoms = Uom::getUoms();

        // check that the given Uom belongs to the given sub class
        if (!array_key_exists($uom->getName(), $uoms[$subClassName])) {
            throw new InvalidUomException($uom->getName());
        }

        $this->amount = $amount;
        $this->uom = $uom;
    }

    /**
     * __toString()
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.6.0
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s %s',
            $this->getAmount(),
            $this->getUom()
        );
    }

    /**
     * Convenience method for creating Quantity objects
     *
     * e.g. Weight::OZ(10), Quantity::EACH(14)
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.3.0
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        if (count($arguments) > 1) {
            return new static(
                new Fraction($arguments[0], $arguments[1]),
                new Uom($method)
            );
        } else {
            return new static(new Fraction($arguments[0]), new Uom($method));
        }
    }

    /**
     * Get amount
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.3.0
     *
     * @return Fraction
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get uom
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.3.0
     *
     * @return Uom
     */
    public function getUom()
    {
        return $this->uom;
    }

    /**
     * Convert this Weight to a new Unit
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.3.0
     *
     * @param Uom $uom
     *
     * @return mixed
     */
    public function to(Uom $uom)
    {
        // Get the conversion factor as a Fraction
        $conversionFactor = Uom::getConversionFactor(
            $this->getUom(),
            $uom
        );

        // Multiply the amount by the conversion factor and create a new
        // Weight with the new Unit
        return new static(
            $this->getAmount()->multiply($conversionFactor),
            $uom
        );
    }

    /**
     * Create Quantity from a string, e.g.
     *
     *     * 1 LB
     *     * 0.5 KG
     *     * 1/2 OZ
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.12.0
     *
     * @param string $string
     *
     * @return mixed
     */
    public static function fromString($string)
    {
        // trim white space
        $string = trim($string);

        // look for the first Uom at the end of the string
        foreach (Uom::getUoms() as $uomGroup) {
            foreach ($uomGroup as $uomName => $description) {
                $expectedPostion = strlen($string) - strlen($uomName);
                $actualPosition = strpos($string, $uomName);

                if ($expectedPostion === $actualPosition) {
                    // ok, we've found a Uom, remove it, leaving the amount
                    $amountAsString = trim(str_replace($uomName, '', $string));

                    // now see if the rest is a fraction
                    try {
                        return new static(
                            Fraction::fromString($amountAsString),
                            new Uom($uomName)
                        );
                    } catch (InvalidArgumentException $e) {
                    }

                    // no, so see if it is float
                    return new static(
                        Fraction::fromFloat($amountAsString),
                        new Uom($uomName)
                    );
                }
            }
        }

        throw new InvalidArgumentException(sprintf(
            'Cannot parse "%s" as a %s',
            $string,
            get_called_class()
        ));
    }

    /**
     * multiplyBy
     *
     * Takes a fraction to multiply the quantity by and returns the new quantity
     *
     * @author Christopher Tatro <c.m.tatro@gmail.com>
     * @since  1.2.0
     *
     * @param Fraction $fraction
     *
     * @return Quantity
     */
    public function multiplyBy(Fraction $fraction)
    {
        return new static($this->getAmount()->multiply($fraction), $this->getUom());
    }

    /**
     * Add
     *
     * Add two quantities together, keeping current Uom
     *
     * @author Christopher Tatro <c.m.tatro@gmail.com>
     * @since  1.2.0
     *
     * @param AbstractQuantity $quantity
     *
     * @return Quantity
     */
    public function add(AbstractQuantity $quantity)
    {
        $convertedQuantity = $quantity->to($this->getUom());

        return new static(
            $this->getAmount()->add($convertedQuantity->getAmount()),
            $this->getUom()
        );
    }

    /**
     * isSameValueAs
     *
     * ValueObject comparison, strict equals
     *
     * @author Christopher Tatro <c.m.tatro@gmail.com>
     * @since 1.2.0
     *
     * @param AbstractQuantity $quantity
     *
     * @return bool
     */
    public function isSameValueAs(AbstractQuantity $quantity)
    {
        // Check the amounts
        if (!$this->getAmount()->isSameValueAs($quantity->getAmount())) {
            return false;
        }

        // Check the unit of measure
        if (!$this->getUom()->isSameValueAs($quantity->getUom())) {
            return false;
        }

        return true;
    }
}
