<?php

/*
 * This file is part of the Сáша framework.
 *
 * (c) tchiotludo <http://github.com/tchiotludo>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Cawa\GoogleMaps\Models;

use Cawa\Date\DateTime;

class OpeningHoursPeriod
{
    /**
     * @param DateTime $open
     * @param DateTime $close
     */
    public function __construct(DateTime $open, DateTime $close)
    {
        $this->open = $open;
        $this->close = $close;
    }

    /**
     * @var DateTime
     */
    private $open;

    /**
     * @return DateTime
     */
    public function getOpen() : DateTime
    {
        return $this->open;
    }

    /**
     * @var DateTime
     */
    private $close;

    /**
     * @return DateTime
     */
    public function getClose() : DateTime
    {
        return $this->close;
    }
}
