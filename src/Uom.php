<?php

/*
 * This file is part of the Phospr Quantity package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phospr;

use Phospr\Fraction;
use Phospr\Exception\Uom\ConversionNotSetException;
use Phospr\Exception\Uom\BadConversionException;

/**
 * Uom (Unit of Measure)
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.3.0
 */
class Uom
{
    /**
     * uoms (Units of Measure)
     *
     * @var array
     */
    private static $uoms;

    /**
     * conversions
     *
     * An array of conversion factors
     *
     * @var array
     */
    private static $conversions;

    /**
     * name
     *
     * @var string
     */
    private $name;

    /**
     * Constructor
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.3.0
     *
     * @param string $name Name of unit, e.g. OZ, LB, KG
     *
     * @throws InvalidUomException
     */
    public function __construct($name)
    {
        // Make sure the name is always caps
        $name = strtoupper($name);

        foreach (static::getUoms() as $type) {
            if (array_key_exists($name, $type)) {
                $this->name = $name;

                return;
            }
        }

        // can't find Uom by name
        throw new Exception\Quantity\InvalidUomException($name);
    }

    /**
     * __toString
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.6.0
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Convenience method for creating Uom objects
     *
     * e.g. Uom::OZ(), Uom::LB();
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.3.0
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return Uom
     */
    public static function __callStatic($method, $arguments)
    {
        return new Uom($method);
    }

    /**
     * Get name
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.3.0
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the conversion factor between two Units of Weight
     *
     * e.g. from LB to OZ = 16
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.3.0
     *
     * @param Uom $from
     * @param Uom $to
     *
     * @throws ConversionNotSetException Thown when a conversion is tried
     * that has not been set in the conversions.json file
     * @throws BadConversionException Thrown when a conversion is not set
     * properly, e.g. [1] should be [1, 16]
     * @return Fraction
     */
    public static function getConversionFactor(Uom $from, Uom $to)
    {
        // Check to see if we need to do a conversion
        if ($from->isSameValueAs($to)) {
            return new Fraction(1);
        }

        if (!isset(static::$conversions)) {
            static::$conversions = json_decode(
                utf8_encode(
                    file_get_contents(__DIR__.'/conversions.json')
                ),
                true
            );
        }

        // First lets see if we have a conversion for the from to to
        if (isset(static::$conversions[$from->getName()][$to->getName()])) {
            $numeratorDenominatorPair = static::$conversions[$from->getName()][$to->getName()];
        // I guess we didn't find one, try the inverse
        } elseif (isset(static::$conversions[$to->getName()][$from->getName()])) {
            // We found the inverse, set the conversion values appropriately
            $numeratorDenominatorPair = array_reverse(static::$conversions[$to->getName()][$from->getName()]);
        } else {
            // no conversion found. throw an exception
            throw new ConversionNotSetException($from->getName(), $to->getName());
        }

        // Is the conversion set up correctly
        if (count($numeratorDenominatorPair) == 2) {
            return new Fraction(
                $numeratorDenominatorPair[0],
                $numeratorDenominatorPair[1]
            );
        } else {
            // Guess it wasn't
            throw new BadConversionException();
        }
    }

    /**
     * Get uoms
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.3.0
     *
     * @return array
     */
    public static function getUoms()
    {
        if (!isset(static::$uoms)) {
            static::$uoms = json_decode(
                utf8_encode(
                    file_get_contents(__DIR__.'/uoms.json')
                ),
                true
            );
        }

        return static::$uoms;
    }

    /**
     * Whether this Uom is equivalent to another
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.10.0
     *
     * @param Uom $other
     *
     * @return bool
     */
    public function isSameValueAs(Uom $other)
    {
        return $this->getName() === $other->getName();
    }
}
