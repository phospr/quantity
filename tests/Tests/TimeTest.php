<?php

/*
 * This file is part of the Quantity package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Quantity\Tests;

use Quantity\Amount,
    Quantity\Time,
    Quantity\Uom;

/**
 * WeightTest
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.4.0
 */
class TimeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test conversions
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.4.0
     */
    public function testConversions()
    {
        $seconds = Time::SECOND(604800);
        $week = $seconds->to(Uom::WEEK());
        $days = $seconds->to(Uom::DAY());
        $hours = $seconds->to(Uom::HOUR());
        $minutes = $seconds->to(Uom::MINUTE());

        $this->assertSame('1', (string) $week->getAmount());
        $this->assertSame('7', (string) $days->getAmount());
        $this->assertSame('168', (string) $hours->getAmount());
        $this->assertSame('168', (string) $hours->getAmount());
        $this->assertSame('10080', (string) $minutes->getAmount());
    }
}
