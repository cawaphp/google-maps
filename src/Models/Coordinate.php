<?php

/*
 * This file is part of the Сáша framework.
 *
 * (c) tchiotludo <http://github.com/tchiotludo>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Cawa\GoogleMaps\Models;

class Coordinate
{
    /**
     * @param float $lat
     * @param float $long
     */
    public function __construct(float $lat, float $long)
    {
        $this->latitude = $lat;
        $this->longitude = $long;
    }

    /**
     * @var float
     */
    private $latitude;

    /**
     * @return float
     */
    public function getLatitude() : float
    {
        return $this->latitude;
    }

    /**
     * @var float
     */
    private $longitude;

    /**
     * @return float
     */
    public function getLongitude() : float
    {
        return $this->longitude;
    }
}
