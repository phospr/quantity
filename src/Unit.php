<?php

/*
 * This file is part of the Quantity package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Quantity;

/**
 * Unit
 *
 * A Value Object to describe the unit of measure of a quantity, e.g. ounces,
 * miles, each
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.1.0
 */
class Unit
{
    /**
     * name
     *
     * @var string
     */
    private $name;

    /**
     * units
     *
     * @var array
     */
    private static $units;

    /**
     * Constructor
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.1.0
     *
     * @param string $name Name of unit, e.g. ounce, mile, each
     *
     * @throws \Quantity\InvalidUnitException
     */
    public function __construct($name)
    {
        if(!isset(static::$units)) {
           static::$units = require __DIR__.'/units.php';
        }

        if (!array_key_exists($name, static::$units)) {
            throw new \Quantity\InvalidUnitException($name);
        }

        $this->name = $name;
    }

    /**
     * Get name
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.1.0
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
