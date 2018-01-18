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

use Cawa\Serializer\ArraySerializable;
use Cawa\Serializer\JsonSerializable;

class GeocoderResult implements \JsonSerializable
{
    use JsonSerializable;
    use ArraySerializable;

    /**
     * The returned result is approximate.
     */
    const LOCATIONTYPE_APPROXIMATE = 'APPROXIMATE';

    /**
     * The returned result is the geometric center of a result such a line (e.g. street) or polygon (region).
     */
    const LOCATIONTYPE_GEOMETRIC_CENTER = 'GEOMETRIC_CENTER';

    /**
     * The returned result reflects an approximation (usually on a road)
     * interpolated between two precise points (such as intersections).
     * Interpolated results are generally returned when rooftop geocodes are unavailable for a street address.
     */
    const LOCATIONTYPE_RANGE_INTERPOLATED = 'RANGE_INTERPOLATED';

    /**
     * The returned result reflects a precise geocode.
     */
    const LOCATIONTYPE_ROOFTOP = 'ROOFTOP';

    /**
     * The place ID is recognised by your application only.
     * This is because your application added the place, and the place has not yet passed the moderation process.
     */
    const SCOPE_APP = 'APP';

    /**
     * The place ID is available to other applications and on Google Maps.
     */
    const SCOPE_GOOGLE = 'GOOGLE';

    /**
     * @param AddressComponent[] $addressComponents
     * @param string $formattedAddress
     * @param Geometry $geometry
     * @param string $placeId
     * @param array $types
     */
    public function __construct(
        array $addressComponents = null,
        string $formattedAddress = null,
        Geometry $geometry = null,
        string $placeId = null,
        array $types = null
    ) {
        $this->addressComponents = $addressComponents;
        $this->formattedAddress = $formattedAddress;
        $this->geometry = $geometry;
        $this->placeId = $placeId;
        $this->types = $types;
    }

    /**
     * @param mixed $data
     * @param string|array $keys
     *
     * @return mixed
     */
    protected static function extract(array &$data, $keys)
    {
        if (!is_array($keys)) {
            $keys = explode('/', $keys);
        }

        if (isset($data[$keys[0]])) {
            if (sizeof($keys) == 1) {
                $return = $data[$keys[0]];
                unset($data[$keys[0]]);

                return $return;
            } else {
                $key = array_shift($keys);
                $return = self::extract($data[$key], $keys);
            }
        }

        return $return ?? null;
    }

    /**
     * @param array $data
     *
     * @return $this|self
     */
    protected static function map(array &$data)
    {
        $return = new static();

        if (isset($data['address_components'])) {
            foreach (self::extract($data, 'address_components') as $current) {
                $return->addressComponents[] = new AddressComponent(
                    $current['long_name'],
                    $current['short_name'],
                    $current['types']
                );
            }
        }

        $viewport = $bounds = null;

        if (isset($data['geometry']['viewport']['northeast'])) {
            $viewport = new Bounds(
                new Coordinate(
                    self::extract($data, 'geometry/viewport/northeast/lat'),
                    self::extract($data, 'geometry/viewport/northeast/lng')
                ),
                new Coordinate(
                    self::extract($data, 'geometry/viewport/southwest/lat'),
                    self::extract($data, 'geometry/viewport/southwest/lng')
                )
            );
        } elseif (isset($data['geometry']['viewport'])) {
            $viewport = new Bounds(
                new Coordinate(
                    self::extract($data, 'geometry/viewport/north'),
                    self::extract($data, 'geometry/viewport/east')
                ),
                new Coordinate(
                    self::extract($data, 'geometry/viewport/south'),
                    self::extract($data, 'geometry/viewport/west')
                )
            );
        }

        if (isset($data['geometry']['bounds'])) {
            if ($data['geometry']['bounds']['northeast']) {
                $bounds = new Bounds(
                    new Coordinate(
                        self::extract($data, 'geometry/bounds/northeast/lat'),
                        self::extract($data, 'geometry/bounds/northeast/lng')
                    ),
                    new Coordinate(
                        self::extract($data, 'geometry/bounds/southwest/lat'),
                        self::extract($data, 'geometry/bounds/southwest/lng')
                    )
                );
            } else {
                $bounds = new Bounds(
                    new Coordinate(
                        self::extract($data, 'geometry/bounds/north'),
                        self::extract($data, 'geometry/bounds/east')
                    ),
                    new Coordinate(
                        self::extract($data, 'geometry/bounds/south'),
                        self::extract($data, 'geometry/bounds/west')
                    )
                );
            }
        }

        $return->geometry = new Geometry(
            new Coordinate(
                self::extract($data, 'geometry/location/lat'),
                self::extract($data, 'geometry/location/lng')
            ),
            self::extract($data, 'geometry/location_type') ?? null,
            $viewport,
            $bounds
        );

        $return->formattedAddress = self::extract($data, 'formatted_address');
        $return->scope = self::extract($data, 'scope');
        $return->placeId = self::extract($data, 'place_id');
        $return->types = self::extract($data, 'types');
        $return->url = self::extract($data, 'url');
        $return->utcOffset = self::extract($data, 'utc_offset');

        return $return;
    }

    /**
     * @param array|string $data
     *
     * @return $this|self
     */
    public static function parse(array $data) : self
    {
        if (isset($data['addressComponents'])) {
            $item = new static();
            $item->jsonUnserialize(json_encode($data));

            return $item;
        }

        return static::map($data);
    }

    /**
     * @var AddressComponent[]
     */
    protected $addressComponents = [];

    /**
     * @param string $type
     *
     * @return AddressComponent
     */
    public function getAddressComponent(string $type)
    {
        foreach ($this->addressComponents as $addressComponent) {
            if (in_array($type, $addressComponent->getTypes())) {
                return $addressComponent;
            }
        }

        return null;
    }

    /**
     * @return array
     */
    public function getAddressComponents() : array
    {
        return $this->addressComponents;
    }

    /**
     * @var string
     */
    protected $formattedAddress;

    /**
     * A string containing the human-readable address of this location.
     *
     * @return string
     */
    public function getFormattedAddress()
    {
        return $this->formattedAddress;
    }

    /**
     * @var Geometry
     */
    protected $geometry;

    /**
     * @return Geometry
     */
    public function getGeometry() : Geometry
    {
        return $this->geometry;
    }

    /**
     * @var string
     */
    protected $placeId;

    /**
     * The place ID associated with the location.
     * Place IDs uniquely identify a place in the Google Places database and on Google Maps.
     *
     * @return string
     */
    public function getPlaceId() : string
    {
        return $this->placeId;
    }

    /**
     * An array of strings denoting the type of the returned geocoded element.
     * AddressComponent::TYPE_* for the full list.
     *
     * @var string[]
     */
    protected $types = [];

    /**
     * @return string[]
     */
    public function getTypes() : array
    {
        return $this->types;
    }

    /**
     * @var string
     */
    protected $scope;

    /**
     * @return string
     */
    public function getScope() : string
    {
        return $this->scope;
    }

    /**
     * @var int
     */
    protected $utcOffset;

    /**
     * @return int
     */
    public function getUtcOffset() : int
    {
        return $this->utcOffset;
    }

    /**
     * @var string
     */
    protected $url;

    /**
     * @return string
     */
    public function getUrl() : string
    {
        return $this->url;
    }
}
