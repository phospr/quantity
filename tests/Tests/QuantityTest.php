<?php

/*
 * This file is part of the Quantity package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Quantity\Tests;

use Quantity\Amount,
    Quantity\Quantity,
    Quantity\Uom;

/**
 * QuantityTest
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.1.0
 */
class QuantityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test constructor
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.1.0
     */
    public function testConstructor()
    {
        $quantity = Quantity::EACH(10);

        $this->assertEquals(new Amount(10), $quantity->getAmount());
        $this->assertSame('EACH', $quantity->getUom()->getName());
    }
}
