<?php

/*
 * This file is part of the Phospr Quantity package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phospr\Exception\Uom;

use UnexpectedValueException;

/**
 * BadConversionException
 *
 * Thrown when a conversion is not set up correctly
 *
 * @author Christopher Tatro <c.m.tatro@gmail.com>
 * @since  0.10.0
 */
class BadConversionException extends UnexpectedValueException
{
    /**
     * __construct
     *
     * @author Christopher Tatro <c.m.tatro@gmail.com>
     * @since  0.10.0
     */
    public function __construct($from, $to)
    {
        parent::__construct(sprintf(
            'The following conversion must have a numerator and denominator: %s to %s',
            $from,
            $to
        ));
    }
}
