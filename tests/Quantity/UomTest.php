<?php

/*
 * This file is part of the Phospr Quantity package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phospr\Tests\Quantity;

use Phospr\Uom;

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

    /**
     * Test isSameValueAs()
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.10.0
     *
     * @dataProvider isSameValueAsProvider
     */
    public function testIsSameValueAs($uom, $other, $same)
    {
        $this->assertSame($same, $uom->isSameValueAs($other));
    }

    /**
     * isSameValueAsProvider
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.10.0
     *
     * @return array
     */
    public static function isSameValueAsProvider()
    {
        $oz = Uom::OZ();

        return [
            [$oz, $oz, true],
            [Uom::OZ(), Uom::OZ(), true],
            [Uom::LB(), Uom::LB(), true],
            [Uom::KG(), Uom::KG(), true],
            [Uom::LB(), Uom::KG(), false],
            [Uom::OZ(), Uom::LB(), false],
        ];
    }
}
