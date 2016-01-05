<?php

/*
 * This file is part of the Phospr Quantity package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phospr\Tests\Quantity;

use Phospr\Fraction;
use Phospr\Weight;
use Phospr\Uom;

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

    /**
     * Test __toString()
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.6.0
     */
    public function testToString()
    {
        $weight = Weight::LB(1, 3);

        $this->assertSame('1/3 LB', (string) $weight);
    }

    /**
     * Test to
     *
     * @author Christopher Tatro <c.m.tatro@gmail.com>
     * @since  0.10.0
     *
     * @dataProvider toProvider
     */
    public function testTo($fromWeight, $fromUom, $toUom, $numerator, $denominator)
    {
        $oldWeight = new Weight(new Fraction((int) $fromWeight), new Uom($fromUom));

        $convertedWeight = $oldWeight->to(new Uom($toUom));
        $this->assertSame($numerator, $convertedWeight->getAmount()->getNumerator());
        $this->assertSame($denominator, $convertedWeight->getAmount()->getDenominator());
    }

    /**
     * toProvider
     *
     * @author Christopher Tatro <c.m.tatro@gmail.com>
     * @since  0.10.0
     */
    public function toProvider()
    {
        return [
            // LBS
            [1, "LB", "KG", 50000, 110231],
            [1, "LB", "OZ", 16, 1],
            // Ounces
            [16, "OZ", "LB", 1, 1],
            [1, "OZ", "KG", 10000000, 352739619],
            [16, "OZ", "KG", 160000000, 352739619],
            // KiloGrams
            [1, "KG", "LB", 110231, 50000],
            [50, "KG", "LB", 110231, 1000],
            [1, "KG", "OZ", 352739619, 10000000],
        ];
    }
}
