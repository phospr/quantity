<?php

/*
 * This file is part of the Quantity package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Quantity;

/**
 * Quantity
 *
 * A Value Object to describe a quantity, which consists of an amount
 * and a unit of measure
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.1.0
 */
class Quantity
{
    /**
     * $amount
     *
     * @var integer
     */
    private $amount;

    /**
     * unit
     *
     * @var \Quantity\Unit
     */
    private $unit;

    /**
     * Constructor
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.1.0
     *
     * @param integer $amount Amount, e.g. 1 (lb), 2 (miles), etc.
     * @param \Quantity\Unit $unit
     *
     * @throws \Quantity\InvalidAmountException
     */
    public function __construct($amount, Unit $unit)
    {
        if (!is_int($amount)) {
            throw new \Quantity\InvalidAmountException(
                'The first parameter of Quantity must be an integer'
            );
        }

        $this->amount = $amount;
        $this->unit = $unit;
    }

    /**
     * Get amount
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.1.0
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get unit
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.1.0
     *
     * @return \Quantity\Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }
}
