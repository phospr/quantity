<?php

/*
 * This file is part of the Quantity package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Quantity;

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
        foreach (static::getUoms() as $type) {
            if (array_key_exists($name, $type)) {
                $this->name = $name;

                return;
            }
        }

        // can't find Uom by name
        throw new InvalidUomException($name);
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
     * @return Fraction
     */
    public static function getConversionFactor(Uom $from, Uom $to)
    {
        if(!isset(static::$conversions)) {
           static::$conversions = require __DIR__.'/conversions.php';
        }

        return static::$conversions[$from->getName()][$to->getName()];
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
        if(!isset(static::$uoms)) {
           static::$uoms = require __DIR__.'/uoms.php';
        }

        return static::$uoms;
    }
}
