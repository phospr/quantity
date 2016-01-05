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
 * ConversionNotSetException
 *
 * Thrown when trying to use an unknown conversion factor
 *
 * @author Christopher Tatro <c.m.tatro@gmail.com>
 * @since  0.10.0
 */
class ConversionNotSetException extends UnexpectedValueException
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
            'The following conversion is not set: %s to %s',
            $from,
            $to
        ));
    }
}
