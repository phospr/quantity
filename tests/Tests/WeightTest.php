<?php

/*
 * This file is part of the Quantity package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Quantity\Tests;

use Quantity\Amount,
    Quantity\Weight,
    Quantity\Uom;

/**
 * WeightTest
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.3.0
 */
class WeightTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test __callStatic
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.3.0
     */
    public function testCallStatic()
    {
        $weight = Weight::LB(10, 20);

        $this->assertSame('LB', $weight->getUom()->getName());
        $this->assertSame('1/2', (string) $weight->getAmount());

        $newWeight = $weight->to(Uom::OZ());

        $this->assertSame('8', (string) $newWeight->getAmount());
    }
}
