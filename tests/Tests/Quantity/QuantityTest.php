<?php

/*
 * This file is part of the Phospr Quantity package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phospr\Tests\Quantity;

use Phospr\Quantity,
    Phospr\Uom;

/**
 * QuantityTest
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.9.0
 */
class QuantityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test __callStatic
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.9.0
     */
    public function testCallStatic()
    {
        $quantity = Quantity::EACH(10);

        $this->assertSame('EACH', $quantity->getUom()->getName());
        $this->assertSame('10', (string) $quantity->getAmount());
    }

    /**
     * Test bad Uom
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.9.0
     *
     * @expectedException Phospr\Exception\Quantity\InvalidUomException
     */
    public function testBadUom()
    {
        $quantity = Quantity::BANANAS(10);
    }

    /**
     * Test __toString()
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.9.0
     */
    public function testToString()
    {
        $quantity = Quantity::EACH(8);

        $this->assertSame('8 EACH', (string) $quantity);
    }
}
