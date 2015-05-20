<?php

/*
 * This file is part of the Quantity package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Quantity\Tests;

use Quantity\Uom;

/**
 * UomTest
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.3.0
 */
class UomTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test __callStatic
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.3.0
     */
    public function testCallStatic()
    {
        $oz = Uom::OZ();
        $this->assertSame('OZ', $oz->getName());
    }

    /**
     * Test __toString
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.6.0
     */
    public function testToString()
    {
        $oz = Uom::OZ();
        $this->assertSame('OZ', (string) $oz);
    }
}
