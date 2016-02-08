<?php

/*
 * This file is part of the Phospr Quantity package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phospr\Tests\Quantity;

use Phospr\Quantity;
use Phospr\Uom;
use PHPUnit_Framework_TestCase;

/**
 * QuantityTest
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.9.0
 */
class QuantityTest extends PHPUnit_Framework_TestCase
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

    /**
     * Test fromString
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.12.0
     *
     * @dataProvider fromStringProvider
     */
    public function testFromString($fromString, $toString)
    {
        $this->assertSame($toString, (string) Quantity::fromString($fromString));
    }

    /**
     * Test fromString exception
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.12.0
     *
     * @dataProvider fromStringExceptionProvider
     * @expectedException InvalidArgumentException
     */
    public function testFromStringException($string)
    {
        Quantity::fromString($string);
    }

    /**
     * Test isSameValueAs
     *
     * @author Christopher Tatro <c.m.tatro@gmail.com>
     * @since 1.2.0
     */
    public function testIsSameValueAs()
    {
        $quantity = Quantity::EACH(10);

        $this->assertTrue($quantity->isSameValueAs(Quantity::EACH(10)));
        $this->assertFalse($quantity->isSameValueAs(Quantity::EACH(9)));
    }

    /**
     * fromString provider
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.12.0
     *
     * @return array
     */
    public static function fromStringProvider()
    {
        return [
            ['1EACH', '1 EACH'],
            ['1 EACH', '1 EACH'],
            ['0.5 EACH', '1/2 EACH'],
            ['2/3 EACH', '2/3 EACH'],
        ];
    }

    /**
     * fromString exception provider
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.12.0
     *
     * @return array
     */
    public static function fromStringExceptionProvider()
    {
        return [
            ['1 LB'],
        ];
    }
}
