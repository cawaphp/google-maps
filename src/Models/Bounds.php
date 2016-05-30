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

class Bounds
{
    /**
     * @param Coordinate $northEast
     * @param Coordinate $southWest
     */
    public function __construct(Coordinate $northEast, Coordinate $southWest)
    {
        $this->northEast = $northEast;
        $this->southWest = $southWest;
    }

    /**
     * @var Coordinate
     */
    protected $northEast;

    /**
     * @return Coordinate
     */
    public function getNorthEast() : Coordinate
    {
        return $this->northEast;
    }

    /**
     * @var Coordinate
     */
    protected $southWest;

    /**
     * @return Coordinate
     */
    public function getSouthWest() : Coordinate
    {
        return $this->southWest;
    }
}
