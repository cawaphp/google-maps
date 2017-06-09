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

class AddressComponent
{
    /**
     * indicates a precise street address.
     */
    const TYPE_STREET_ADDRESS = 'street_address';

    /**
     * indicates a named route (such as "US 101").
     */
    const TYPE_ROUTE = 'route';

    /**
     * indicates a major intersection, usually of two major roads.
     */
    const TYPE_INTERSECTION = 'intersection';

    /**
     * indicates a political entity. Usually, this type indicates a polygon of some
     * civil administration.
     */
    const TYPE_POLITICAL = 'political';

    /**
     * indicates the national political entity, and is typically the highest order
     * type returned by the Geocoder.
     */
    const TYPE_COUNTRY = 'country';

    /**
     * indicates a first-order civil entity below the country level.
     * Within the United States, these administrative levels are states.
     * Not all nations exhibit these administrative levels.
     */
    const TYPE_ADMINISTRATIVE_AREA_LEVEL_1 = 'administrative_area_level_1';

    /**
     * indicates a second-order civil entity below the country level.
     * Within the United States, these administrative levels are counties.
     * Not all nations exhibit these administrative levels.
     */
    const TYPE_ADMINISTRATIVE_AREA_LEVEL_2 = 'administrative_area_level_2';

    /**
     * indicates a third-order civil entity below the country level.
     * This type indicates a minor civil division.
     * Not all nations exhibit these administrative levels.
     */
    const TYPE_ADMINISTRATIVE_AREA_LEVEL_3 = 'administrative_area_level_3';

    /**
     * indicates a fourth-order civil entity below the country level.
     * This type indicates a minor civil division.
     * Not all nations exhibit these administrative levels.
     */
    const TYPE_ADMINISTRATIVE_AREA_LEVEL_4 = 'administrative_area_level_4';

    /**
     * indicates a fifth-order civil entity below the country level.
     * This type indicates a minor civil division.
     * Not all nations exhibit these administrative levels.
     */
    const TYPE_ADMINISTRATIVE_AREA_LEVEL_5 = 'administrative_area_level_5';

    /**
     * indicates a commonly-used alternative name for the entity.
     */
    const TYPE_COLLOQUIAL_AREA = 'colloquial_area';

    /**
     * indicates an incorporated city or town political entity.
     */
    const TYPE_LOCALITY = 'locality';

    /**
     * indicates a first-order civil entity below a locality. For some locations
     * may receive one of the additional types: sublocality_level_1 to sublocality_level_5. Each
     * sublocality level is a civil entity. Larger numbers indicate a smaller geographic area.
     */
    const TYPE_SUBLOCALITY = 'sublocality';
    const TYPE_SUBLOCALITY_LEVEL_1 = 'sublocality_level_1';
    const TYPE_SUBLOCALITY_LEVEL_2 = 'sublocality_level_2';
    const TYPE_SUBLOCALITY_LEVEL_3 = 'sublocality_level_3';
    const TYPE_SUBLOCALITY_LEVEL_4 = 'sublocality_level_4';
    const TYPE_SUBLOCALITY_LEVEL_5 = 'sublocality_level_5';

    /**
     * indicates a named neighborhood.
     */
    const TYPE_NEIGHBORHOOD = 'neighborhood';

    /**
     * indicates a named location, usually a building or collection of buildings with
     * a common name.
     */
    const TYPE_PREMISE = 'premise';

    /**
     * indicates a first-order entity below a named location, usually a singular
     * building within a collection of buildings with a common name.
     */
    const TYPE_SUBPREMISE = 'subpremise';

    /**
     * indicates a postal code as used to address postal mail within the country.
     */
    const TYPE_POSTAL_CODE = 'postal_code';

    /**
     * indicates a postal code prefix as used to address postal mail within
     * the country.
     */
    const TYPE_POSTAL_CODE_PREFIX = 'postal_code_prefix';

    /**
     * indicates a postal code suffix as used to address postal mail within
     * the country.
     */
    const TYPE_POSTAL_CODE_SUFFIX = 'postal_code_suffix';

    /**
     * indicates a prominent natural feature.
     */
    const TYPE_NATURAL_FEATURE = 'natural_feature';

    /**
     * indicates an airport.
     */
    const TYPE_AIRPORT = 'airport';

    /**
     * indicates a named park.
     */
    const TYPE_PARK = 'park';

    /**
     * indicates a named point of interest. Typically, these "POI"s are
     * prominent local entities that don't easily fit in another category, such as "Empire State
     * Building" or "Statue of Liberty.".
     */
    const TYPE_POINT_OF_INTEREST = 'point_of_interest';

    /**
     * indicates the floor of a building address.
     */
    const TYPE_FLOOR = 'floor';

    /**
     * typically indicates a place that has not yet been categorized.
     */
    const TYPE_ESTABLISHMENT = 'establishment';

    /**
     * indicates a parking lot or parking structure.
     */
    const TYPE_PARKING = 'parking';

    /**
     * indicates a specific postal box.
     */
    const TYPE_POST_BOX = 'post_box';

    /**
     * indicates a grouping of geographic areas, such as locality and sublocality,
     * used for mailing addresses in some countries.
     */
    const TYPE_POSTAL_TOWN = 'postal_town';

    /**
     * indicates the room of a building address.
     */
    const TYPE_ROOM = 'room';

    /**
     * indicates the precise street number.
     */
    const TYPE_STREET_NUMBER = 'street_number';

    /**
     * indicates the location of a bus stop.
     */
    const TYPE_BUS_STATION = 'bus_station';

    /**
     * indicates the location of a train station.
     */
    const TYPE_TRAIN_STATION = 'train_station';

    /**
     * indicates the location of a subway station.
     */
    const TYPE_SUBWAY_STATION = 'subway_station';

    /**
     * indicates the location of a transit station.
     */
    const TYPE_TRANSIT_STATION = 'transit_station';

    /**
     * indicates a specific type of Japanese locality,
     * to facilitate distinction between multiple locality components within a Japanese address.
     */
    const TYPE_WARD = 'ward';

    /**
     * Indicates an unknown address component type returned by the server.
     * The client should be updated to support the new value.
     */
    const TYPE_UNKNOWN = 'unknown';

    /**
     * @param string $longName
     * @param string $shortName
     * @param array $types
     */
    public function __construct(string $longName, string $shortName, array $types)
    {
        $this->longName = $longName;
        $this->shortName = $shortName;
        $this->types = $types;
    }

    /**
     * @var string
     */
    private $longName;

    /**
     * Gets the address component long name.
     *
     * @return string the address component long name
     */
    public function getLongName() : string
    {
        return $this->longName;
    }

    /**
     * @var string
     */
    private $shortName;

    /**
     * Gets the address component short name.
     *
     * @return string the address component short name
     */
    public function getShortName() : string
    {
        return $this->shortName;
    }

    /**
     * @var array
     */
    private $types = [];

    /**
     * Gets the address component types.
     *
     * @return array the address component types
     */
    public function getTypes() : array
    {
        return $this->types;
    }
}
