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

class Geometry
{
    /**
     * @param Coordinate $location
     * @param string $locationType
     * @param Bounds $viewport
     * @param Bounds|null $bounds
     */
    public function __construct(
        Coordinate $location,
        string $locationType = null,
        Bounds $viewport = null,
        Bounds $bounds = null
    ) {
        $this->location = $location;
        $this->locationType = $locationType;
        $this->viewport = $viewport;
        $this->bounds = $bounds;
    }

    /**
     * @var Coordinate
     */
    protected $location;

    /**
     * @return Coordinate
     */
    public function getLocation() : Coordinate
    {
        return $this->location;
    }

    /**
     * @var string
     */
    protected $locationType;

    /**
     * @return string
     */
    public function getLocationType() : string
    {
        return $this->locationType;
    }

    /**
     * @var Bounds
     */
    protected $viewport;

    /**
     * @return Bounds
     */
    public function getViewport() : Bounds
    {
        return $this->viewport;
    }

    /**
     * @var Bounds
     */
    protected $bounds;

    /**
     * @return Bounds
     */
    public function getBounds() : Bounds
    {
        return $this->bounds;
    }
}
